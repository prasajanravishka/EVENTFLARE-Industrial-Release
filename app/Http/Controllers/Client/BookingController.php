<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\EventExtra;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display booking creation form / wizard launcher.
     */
    public function create(Request $request)
    {
        $eventTypes = EventType::active()->orderBy('event_type_id')->get();
        $preEvent = $request->query('event', '');
        $preVenue = $request->query('venue', '');
        $preGuests = (int) $request->query('guests', 0);
        $prePackage = $request->query('package', '');
        $preDetails = $request->query('details', '');

        if (!empty($prePackage) && empty($preDetails)) {
            $preDetails = 'Interested in Package: ' . $prePackage;
        }

        // If specific category is requested, load itemized services and suppliers
        $selectedType = null;
        $services = collect();
        if (!empty($preEvent)) {
            $selectedType = EventType::where('type_name', 'like', "%{$preEvent}%")->first();
            if ($selectedType) {
                $services = Service::with(['listings.supplier', 'suppliers'])
                    ->where('event_type_id', $selectedType->event_type_id)
                    ->orderBy('priority_rank')
                    ->get();
            }
        }

        return view('client.bookings.create', compact(
            'eventTypes',
            'preEvent',
            'preVenue',
            'preGuests',
            'prePackage',
            'preDetails',
            'selectedType',
            'services'
        ));
    }

    /**
     * Store a newly created booking with collision-resistant ID and atomic transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'EventType' => 'required|string|max:100',
            'Place' => 'required|string|max:255',
            'NumberOfGuests' => 'required|integer|min:1|max:50000',
            'EventDate' => 'required|date|after_or_equal:today',
            'DayNight' => 'required|in:Day,Night',
            'FoodPreferences' => 'required|string|max:100',
            'ExtraDetails' => 'nullable|string|max:2000',
            'equipment' => 'nullable|string|max:255',
            'food_style' => 'nullable|string|max:100',
            'selected_packages' => 'nullable|array',
            'selected_packages.*' => 'nullable|integer',
        ]);

        $user = Auth::user();

        // Generate collision-resistant unique Booking ID (BKG + 8 uppercase hex)
        $bookingId = 'BKG-' . strtoupper(Str::random(8));

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'BookingID' => $bookingId,
                'user_id' => $user->id,
                'user_name' => $user->username,
                'EventType' => $validated['EventType'],
                'Place' => $validated['Place'],
                'NumberOfGuests' => $validated['NumberOfGuests'],
                'EventDate' => $validated['EventDate'],
                'DayNight' => $validated['DayNight'],
                'FoodPreferences' => $validated['FoodPreferences'],
                'ExtraDetails' => $validated['ExtraDetails'] ?? null,
                'status' => 'pending',
            ]);

            // Persist optional event extras
            if (!empty($validated['equipment']) || !empty($validated['food_style'])) {
                EventExtra::create([
                    'booking_id' => $bookingId,
                    'equipment' => $validated['equipment'] ?? 'Standard Stage, Ambient Lighting & AV Setup',
                    'food_style' => $validated['food_style'] ?? $validated['FoodPreferences'],
                ]);
            }

            // Persist package selections if any
            if (!empty($validated['selected_packages'])) {
                foreach ($validated['selected_packages'] as $serviceId => $listingId) {
                    if (!empty($listingId)) {
                        $listing = \App\Models\SupplierListing::find($listingId);
                        if ($listing) {
                            BookingService::create([
                                'booking_id' => $bookingId,
                                'service_id' => $serviceId,
                                'supplier_id' => $listing->supplier_id,
                                'listing_id' => $listing->listing_id,
                                'assigned_cost' => $listing->price,
                                'status' => 'confirmed',
                                'custom_notes' => 'Selected during initial booking wizard',
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            // Dispatch notification email safely to client
            try {
                if ($user = Auth::user()) {
                    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\BookingConfirmationMail($booking));
                }
            } catch (\Throwable $mailErr) {
                \Illuminate\Support\Facades\Log::warning("Failed to send booking confirmation email: " . $mailErr->getMessage());
            }

            return redirect()->route('client.bookings')
                ->with('success', "Reservation successfully created! Your Booking Reference is #{$bookingId}");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Unable to complete reservation: ' . $e->getMessage());
        }
    }

    /**
     * Display client's personal bookings list.
     */
    public function index()
    {
        $userId = Auth::id();
        $username = Auth::user()->username;

        $bookings = Booking::with([
            'extra',
            'services.service',
            'services.supplier',
            'services.listing',
            'ratings',
        ])
        ->where(function ($query) use ($userId, $username) {
            $query->where('user_id', $userId)
                  ->orWhere('user_name', $username);
        })
        ->orderBy('EventDate', 'desc')
        ->get();

        return view('client.bookings.index', compact('bookings'));
    }

    /**
     * Show booking details / dossier modal data.
     */
    public function show(string $id)
    {
        $booking = Booking::with([
            'extra',
            'services.service',
            'services.supplier',
            'services.listing',
            'ratings',
        ])->where('BookingID', $id)
          ->where(function ($query) {
              $query->where('user_id', Auth::id())
                    ->orWhere('user_name', Auth::user()->username);
          })
          ->firstOrFail();

        return view('client.bookings.show', compact('booking'));
    }

    /**
     * Export / Download itinerary and voucher slip as PDF.
     */
    public function pdf(string $id)
    {
        $booking = Booking::with([
            'extra',
            'services.service',
            'services.supplier',
            'services.listing',
            'user',
        ])->where('BookingID', $id)
          ->where(function ($query) {
              $query->where('user_id', Auth::id())
                    ->orWhere('user_name', Auth::user()->username);
          })
          ->firstOrFail();

        $pdf = Pdf::loadView('client.bookings.pdf', compact('booking'));
        $filename = "EVENTFLARE-Reservation-{$booking->BookingID}.pdf";

        return $pdf->download($filename);
    }
}
