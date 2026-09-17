<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\EventType;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierListing;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    /**
     * Display all reservations with filters & pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $statusFilter = $request->query('status', '');
        $typeFilter = $request->query('type', '');

        $query = Booking::with(['user', 'services.service', 'services.supplier', 'services.listing', 'extra']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('BookingID', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('Place', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('fullname', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($statusFilter)) {
            $query->where('status', $statusFilter);
        }

        if (!empty($typeFilter)) {
            $query->where('EventType', $typeFilter);
        }

        $bookings = $query->orderBy('EventDate', 'desc')->paginate(12)->withQueryString();
        $eventTypes = EventType::active()->get();
        $suppliers = Supplier::with('services')->orderBy('business_name')->get();

        return view('admin.bookings.index', compact('bookings', 'eventTypes', 'suppliers', 'search', 'statusFilter', 'typeFilter'));
    }

    /**
     * Display comprehensive booking dossier with lifecycle progression across all stages.
     */
    public function show(string $id)
    {
        $booking = Booking::with([
            'user',
            'services.service.eventType',
            'services.supplier.user',
            'services.listing',
            'extra',
            'ratings.user',
            'caseStudy',
        ])->where('BookingID', $id)->firstOrFail();

        // Retrieve event type catalog services and available accredited suppliers for assignments
        $eventType = EventType::where('type_name', $booking->EventType)->first();
        $catalogServices = $eventType ? $eventType->services : Service::all();
        $suppliers = Supplier::with(['services', 'listings'])->orderBy('business_name')->get();

        return view('admin.bookings.show', compact('booking', 'catalogServices', 'suppliers'));
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,in progress,in_progress,completed,cancelled',
        ]);

        $booking = Booking::with('user')->where('BookingID', $id)->firstOrFail();
        $oldStatus = $booking->status;
        $booking->status = $validated['status'];
        $booking->save();

        // Dispatch status updated email to customer
        try {
            if ($booking->user && $booking->user->email) {
                \Illuminate\Support\Facades\Mail::to($booking->user->email)->send(new \App\Mail\BookingStatusUpdatedMail($booking, $oldStatus));
            }
        } catch (\Throwable $mailErr) {
            \Illuminate\Support\Facades\Log::warning("Failed to send booking status email: " . $mailErr->getMessage());
        }

        return back()->with('success', "Booking #{$id} status updated to " . ucfirst($validated['status']) . ".");
    }

    /**
     * Delete booking permanently.
     */
    public function destroy(string $id)
    {
        $booking = Booking::where('BookingID', $id)->firstOrFail();
        $booking->delete();

        return back()->with('success', "Booking #{$id} has been permanently deleted.");
    }

    /**
     * Assign a supplier / service line item to a booking.
     */
    public function assignSupplier(Request $request, string $id)
    {
        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,service_id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'listing_id' => 'nullable|integer|exists:supplier_listings,listing_id',
            'custom_notes' => 'nullable|string|max:1000',
            'assigned_cost' => 'nullable|numeric|min:0',
        ]);

        $booking = Booking::where('BookingID', $id)->firstOrFail();
        $supplier = Supplier::with('user')->findOrFail($validated['supplier_id']);

        BookingService::updateOrCreate(
            [
                'booking_id' => $id,
                'service_id' => $validated['service_id'],
            ],
            [
                'supplier_id' => $validated['supplier_id'],
                'listing_id' => $validated['listing_id'] ?? null,
                'custom_notes' => $validated['custom_notes'] ?? null,
                'assigned_cost' => $validated['assigned_cost'] ?? 0,
                'status' => 'confirmed',
            ]
        );

        // Notify the assigned supplier
        try {
            $supplierEmail = $supplier->user->email ?? $supplier->contact_number;
            if ($supplier->user && $supplier->user->email) {
                \Illuminate\Support\Facades\Mail::to($supplier->user->email)->send(new \App\Mail\SupplierAssignedMail($booking, $supplier));
            }
        } catch (\Throwable $mailErr) {
            \Illuminate\Support\Facades\Log::warning("Failed to send supplier assignment email: " . $mailErr->getMessage());
        }

        return back()->with('success', "Supplier assigned to booking #{$id} successfully.");
    }

    /**
     * Remove an assigned service-supplier line from a booking.
     */
    public function removeAssignment(int $assignmentId)
    {
        $bs = BookingService::findOrFail($assignmentId);
        $bs->delete();

        return back()->with('success', 'Supplier service assignment removed.');
    }
}
