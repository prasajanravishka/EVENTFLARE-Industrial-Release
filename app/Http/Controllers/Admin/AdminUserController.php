<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierListing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display client accounts (buyers) with KPIs, activity filters, and sorting.
     */
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $activity = $request->query('activity', 'all');
        $sort = $request->query('sort', 'latest');

        // High-level KPI aggregations for client directory
        $totalClients = User::where('role', 'buyer')->count();
        $activeClients = User::where('role', 'buyer')->has('bookings')->count();
        $dormantClients = User::where('role', 'buyer')->doesntHave('bookings')->count();
        $totalBookings = Booking::count();
        $totalSuppliersCount = Supplier::count();

        $query = User::withCount('bookings')
            ->with(['bookings' => function ($bq) {
                $bq->latest('created_at');
            }])
            ->where('role', 'buyer');

        // Search by username, full name, or email
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('fullname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Activity filter
        if ($activity === 'active') {
            $query->has('bookings');
        } elseif ($activity === 'inactive') {
            $query->doesntHave('bookings');
        }

        // Flexible sorting
        switch ($sort) {
            case 'oldest':
                $query->oldest('id');
                break;
            case 'most_bookings':
                $query->orderByDesc('bookings_count')->latest('id');
                break;
            case 'least_bookings':
                $query->orderBy('bookings_count')->latest('id');
                break;
            case 'name_asc':
                $query->orderBy('fullname')->orderBy('username');
                break;
            case 'latest':
            default:
                $query->latest('id');
                break;
        }

        $users = $query->paginate(12)->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'search',
            'activity',
            'sort',
            'totalClients',
            'activeClients',
            'dormantClients',
            'totalBookings',
            'totalSuppliersCount'
        ));
    }

    /**
     * Display suppliers list in Admin Console with KPIs and service catalogs.
     */
    public function suppliers(Request $request)
    {
        $search = $request->query('search', '');

        // Supplier KPI aggregations
        $totalSuppliers = Supplier::count();
        $totalCategories = Supplier::distinct('category')->count('category');
        $totalServices = DB::table('supplier_services')->count();
        $totalListings = SupplierListing::count();
        $totalClientsCount = User::where('role', 'buyer')->count();

        $query = Supplier::with(['user', 'services.eventType', 'listings.service']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('username', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $suppliers = $query->latest('id')->paginate(12)->withQueryString();
        $allServices = Service::with('eventType')->orderBy('service_name')->get();

        return view('admin.suppliers.index', compact(
            'suppliers',
            'allServices',
            'search',
            'totalSuppliers',
            'totalCategories',
            'totalServices',
            'totalListings',
            'totalClientsCount'
        ));
    }

    /**
     * Store a newly created supplier (creates user + supplier profile + accredited services atomically).
     */
    public function storeSupplier(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'fullname' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            'business_name' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'contact_phone' => 'required|string|max:20',
            'location' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
            'services' => 'nullable|array',
            'services.*' => 'integer|exists:services,service_id',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'username' => $validated['username'],
                'fullname' => $validated['fullname'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'supplier',
            ]);

            $supplier = Supplier::create([
                'user_id' => $user->id,
                'business_name' => $validated['business_name'],
                'category' => $validated['category'],
                'contact_phone' => $validated['contact_phone'],
                'location' => $validated['location'],
                'description' => $validated['description'] ?? null,
            ]);

            if (!empty($validated['services'])) {
                $supplier->services()->sync($validated['services']);
            }

            DB::commit();

            $serviceCount = !empty($validated['services']) ? count($validated['services']) : 0;
            return back()->with('success', "Supplier '{$validated['business_name']}' onboarded successfully with {$serviceCount} accredited service(s).");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create supplier: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing supplier profile and synchronized accredited services.
     */
    public function updateSupplier(Request $request, int $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'business_name' => 'required|string|max:150',
            'fullname' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'contact_phone' => 'required|string|max:20',
            'location' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
            'services' => 'nullable|array',
            'services.*' => 'integer|exists:services,service_id',
        ]);

        DB::transaction(function () use ($supplier, $validated) {
            $supplier->update([
                'business_name' => $validated['business_name'],
                'category' => $validated['category'],
                'contact_phone' => $validated['contact_phone'],
                'location' => $validated['location'],
                'description' => $validated['description'] ?? null,
            ]);

            if ($supplier->user) {
                $supplier->user->fullname = $validated['fullname'];
                $supplier->user->save();
            }

            $supplier->services()->sync($validated['services'] ?? []);
        });

        return back()->with('success', "Supplier '{$supplier->business_name}' updated successfully.");
    }

    /**
     * Delete supplier profile and associated user account.
     */
    public function destroySupplier(int $id)
    {
        $supplier = Supplier::with('user')->findOrFail($id);
        $name = $supplier->business_name;
        $user = $supplier->user;

        DB::transaction(function () use ($supplier, $user) {
            $supplier->delete();
            if ($user) {
                $user->delete();
            }
        });

        return back()->with('success', "Supplier '{$name}' and associated account deleted successfully.");
    }

    /**
     * Delete user account (cascade will handle related entries).
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $name = $user->username;
        $user->delete();

        return back()->with('success', "Account '{$name}' has been deleted.");
    }
}
