<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display client accounts (buyers).
     */
    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $query = User::withCount('bookings')
            ->where('role', 'buyer');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('fullname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest('id')->paginate(12)->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Display suppliers list in Admin Console.
     */
    public function suppliers(Request $request)
    {
        $search = $request->query('search', '');

        $query = Supplier::with(['user', 'services', 'listings']);

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
        $allServices = Service::with('eventType')->get();

        return view('admin.suppliers.index', compact('suppliers', 'allServices', 'search'));
    }

    /**
     * Store a newly created supplier (creates user + supplier profile).
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
            'contact_phone' => 'required|string|max:50',
            'location' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
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

            Supplier::create([
                'user_id' => $user->id,
                'business_name' => $validated['business_name'],
                'category' => $validated['category'],
                'contact_phone' => $validated['contact_phone'],
                'location' => $validated['location'],
                'description' => $validated['description'] ?? null,
            ]);

            DB::commit();

            return back()->with('success', "Supplier '{$validated['business_name']}' created successfully.");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create supplier: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing supplier.
     */
    public function updateSupplier(Request $request, int $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'business_name' => 'required|string|max:150',
            'fullname' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'contact_phone' => 'required|string|max:50',
            'location' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
        ]);

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

        return back()->with('success', "Supplier '{$supplier->business_name}' updated successfully.");
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
