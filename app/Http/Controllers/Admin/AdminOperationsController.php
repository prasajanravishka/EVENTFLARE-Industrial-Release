<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Budget;
use App\Models\ContactMessage;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierListing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminOperationsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Ratings & Reviews Management
    |--------------------------------------------------------------------------
    */
    public function ratings(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Rating::with(['user', 'supplier', 'booking']);

        if ($status === 'pending') {
            $query->where('admin_status', 'pending');
        } elseif ($status === 'approved') {
            $query->where('admin_status', 'approved');
        } elseif ($status === 'hidden') {
            $query->where('admin_status', 'hidden');
        }

        $ratings = $query->latest('id')->paginate(15)->withQueryString();

        return view('admin.ratings.index', compact('ratings', 'status'));
    }

    public function toggleRating(int $id)
    {
        $rating = Rating::findOrFail($id);
        $rating->admin_status = ($rating->admin_status === 'approved') ? 'hidden' : 'approved';
        $rating->save();

        return back()->with('success', "Review #{$id} status updated to {$rating->admin_status}.");
    }

    public function destroyRating(int $id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return back()->with('success', "Review #{$id} deleted successfully.");
    }

    /*
    |--------------------------------------------------------------------------
    | Event Types & Services Catalog
    |--------------------------------------------------------------------------
    */
    public function eventTypes()
    {
        $eventTypes = EventType::with(['services' => function ($q) {
            $q->with([
                'suppliers.user',
                'listings' => function ($l) {
                    $l->select('listing_id', 'service_id', 'title', 'price', 'status')->where('status', 'active');
                },
            ])->withCount(['suppliers', 'listings'])->orderBy('priority_rank');
        }])->orderBy('event_type_id')->get();

        // Calculate pricing metrics for each service
        foreach ($eventTypes as $et) {
            foreach ($et->services as $srv) {
                $srv->min_price = $srv->listings->min('price');
                $srv->max_price = $srv->listings->max('price');
                $srv->avg_price = $srv->listings->avg('price');
            }
        }

        $allSuppliers = Supplier::with('user')->orderBy('business_name')->get();

        $stats = [
            'total_categories' => $eventTypes->count(),
            'active_categories' => $eventTypes->where('is_active', true)->count(),
            'archived_categories' => $eventTypes->where('is_active', false)->count(),
            'total_services' => $eventTypes->sum(fn ($et) => $et->services->count()),
            'mandatory_services' => $eventTypes->sum(fn ($et) => $et->services->where('is_required', true)->count()),
        ];

        return view('admin.event-types.index', compact('eventTypes', 'stats', 'allSuppliers'));
    }

    public function storeEventType(Request $request)
    {
        $validated = $request->validate([
            'type_name' => 'required|string|max:100|unique:event_types,type_name',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_url' => 'nullable|string|max:500',
            'badge' => 'nullable|string|max:100',
            'chips' => 'nullable|string|max:255',
            'vendor_count_label' => 'nullable|string|max:100',
            'accent_color' => 'nullable|string|max:30',
            'is_active' => 'nullable|boolean',
        ]);

        $imageUrl = $validated['image_url'] ?? null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('event_types/images', 'public');
            $imageUrl = '/storage/' . $path;
        }

        EventType::create([
            'type_name' => $validated['type_name'],
            'description' => $validated['description'] ?? null,
            'image_url' => $imageUrl,
            'badge' => $validated['badge'] ?? null,
            'chips' => $validated['chips'] ?? null,
            'vendor_count_label' => $validated['vendor_count_label'] ?? null,
            'accent_color' => $validated['accent_color'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', "Event Category '{$validated['type_name']}' created successfully.");
    }

    public function updateEventType(Request $request, int $id)
    {
        $eventType = EventType::findOrFail($id);

        $validated = $request->validate([
            'type_name' => 'required|string|max:100|unique:event_types,type_name,' . $eventType->event_type_id . ',event_type_id',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_url' => 'nullable|string|max:500',
            'badge' => 'nullable|string|max:100',
            'chips' => 'nullable|string|max:255',
            'vendor_count_label' => 'nullable|string|max:100',
            'accent_color' => 'nullable|string|max:30',
            'is_active' => 'nullable|boolean',
        ]);

        $imageUrl = $eventType->image_url;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('event_types/images', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $imageUrl = $validated['image_url'];
        }

        $eventType->update([
            'type_name' => $validated['type_name'],
            'description' => $validated['description'] ?? null,
            'image_url' => $imageUrl,
            'badge' => $validated['badge'] ?? null,
            'chips' => $validated['chips'] ?? null,
            'vendor_count_label' => $validated['vendor_count_label'] ?? null,
            'accent_color' => $validated['accent_color'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', "Event Category '{$eventType->type_name}' updated successfully.");
    }

    public function toggleEventType(int $id)
    {
        $eventType = EventType::findOrFail($id);
        $eventType->is_active = !$eventType->is_active;
        $eventType->save();

        $state = $eventType->is_active ? 'Activated' : 'Archived';
        return back()->with('success', "Category '{$eventType->type_name}' has been {$state}.");
    }

    public function destroyEventType(int $id)
    {
        $eventType = EventType::with('services')->findOrFail($id);

        // Safeguard 1: check if bookings exist under this category
        $bookingCount = Booking::where('EventType', $eventType->type_name)->count();
        if ($bookingCount > 0) {
            return back()->with('error', "Cannot delete category '{$eventType->type_name}': {$bookingCount} customer reservations are currently linked to it. Please archive it instead.");
        }

        // Safeguard 2: check if any services under this category have booking line items or packages
        $serviceIds = $eventType->services->pluck('service_id');
        $bookingServicesCount = BookingService::whereIn('service_id', $serviceIds)->count();
        $listingsCount = SupplierListing::whereIn('service_id', $serviceIds)->count();

        if ($bookingServicesCount > 0 || $listingsCount > 0) {
            return back()->with('error', "Cannot delete category: Services under it have {$bookingServicesCount} booking assignments and {$listingsCount} supplier packages. Please remove them first.");
        }

        $categoryName = $eventType->type_name;
        $eventType->delete();

        return back()->with('success', "Event Category '{$categoryName}' and its catalog services removed successfully.");
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'event_type_id' => 'required|integer|exists:event_types,event_type_id',
            'service_name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'priority_rank' => 'required|integer|min:1',
            'typical_capacity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'is_required' => 'nullable|boolean',
        ]);

        Service::create([
            'event_type_id' => $validated['event_type_id'],
            'service_name' => $validated['service_name'],
            'description' => $validated['description'] ?? '',
            'priority_rank' => $validated['priority_rank'],
            'typical_capacity' => $validated['typical_capacity'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'is_required' => $request->boolean('is_required'),
        ]);

        return back()->with('success', "Service '{$validated['service_name']}' added to category catalog.");
    }

    public function updateService(Request $request, int $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'event_type_id' => 'required|integer|exists:event_types,event_type_id',
            'service_name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'priority_rank' => 'required|integer|min:1',
            'typical_capacity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'is_required' => 'nullable|boolean',
        ]);

        $service->update([
            'event_type_id' => $validated['event_type_id'],
            'service_name' => $validated['service_name'],
            'description' => $validated['description'] ?? '',
            'priority_rank' => $validated['priority_rank'],
            'typical_capacity' => $validated['typical_capacity'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'is_required' => $request->boolean('is_required'),
        ]);

        return back()->with('success', "Service '{$service->service_name}' updated successfully.");
    }

    public function destroyService(int $id)
    {
        $service = Service::findOrFail($id);

        // Safeguard 1: check booking services
        $bookingCount = BookingService::where('service_id', $service->service_id)->count();
        if ($bookingCount > 0) {
            return back()->with('error', "Cannot delete service '{$service->service_name}': Currently assigned to {$bookingCount} active event reservations.");
        }

        // Safeguard 2: check supplier listings
        $listingCount = SupplierListing::where('service_id', $service->service_id)->count();
        if ($listingCount > 0) {
            return back()->with('error', "Cannot delete service '{$service->service_name}': {$listingCount} supplier packages are published under it.");
        }

        $service->suppliers()->detach();
        $serviceName = $service->service_name;
        $service->delete();

        return back()->with('success', "Service '{$serviceName}' removed from catalog.");
    }

    public function quickAssignSupplier(Request $request, int $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'supplier_id' => 'required|integer|exists:suppliers,id',
        ]);

        $supplier = Supplier::findOrFail($validated['supplier_id']);
        $service->suppliers()->syncWithoutDetaching([$supplier->id]);

        return back()->with('success', "Vendor '{$supplier->business_name}' accredited for service '{$service->service_name}' successfully.");
    }

    public function quickRemoveSupplier(int $id, int $supplierId)
    {
        $service = Service::findOrFail($id);
        $supplier = Supplier::findOrFail($supplierId);

        $service->suppliers()->detach($supplierId);

        return back()->with('success', "Accreditation for vendor '{$supplier->business_name}' removed from '{$service->service_name}'.");
    }

    /*
    |--------------------------------------------------------------------------
    | Budgets Audit
    |--------------------------------------------------------------------------
    */
    public function budgets()
    {
        $totals = [
            'total_budget' => (float) Budget::sum('total_budget'),
            'food_budget' => (float) Budget::sum('food_budget'),
            'total_spent' => (float) Budget::sum('total_spent'),
            'remaining' => (float) Budget::sum('remaining_budget'),
            'count' => Budget::count(),
        ];

        $budgets = Budget::latest('id')->paginate(15);

        return view('admin.budgets.index', compact('totals', 'budgets'));
    }

    /*
    |--------------------------------------------------------------------------
    | Contact Messages & Inquiries
    |--------------------------------------------------------------------------
    */
    public function messages(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = ContactMessage::query();

        if ($filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($filter === 'read') {
            $query->where('is_read', true);
        }

        $messages = $query->latest('id')->paginate(15)->withQueryString();

        return view('admin.messages.index', compact('messages', 'filter'));
    }

    public function toggleMessageRead(int $id)
    {
        $msg = ContactMessage::findOrFail($id);
        $msg->is_read = !$msg->is_read;
        $msg->save();

        return back()->with('success', 'Message status updated.');
    }

    public function destroyMessage(int $id)
    {
        $msg = ContactMessage::findOrFail($id);
        $msg->delete();

        return back()->with('success', 'Inquiry message removed.');
    }

    /*
    |--------------------------------------------------------------------------
    | Staff & Administrators
    |--------------------------------------------------------------------------
    */
    public function staff()
    {
        $admins = User::where('role', 'admin')->latest('id')->get();
        return view('admin.staff.index', compact('admins'));
    }

    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'fullname' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'username' => $validated['username'],
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        return back()->with('success', "New administrator '{$validated['username']}' provisioned successfully.");
    }
}
