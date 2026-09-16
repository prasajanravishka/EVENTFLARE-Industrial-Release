<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierListingController extends Controller
{
    /**
     * Display listings belonging to the authenticated supplier.
     */
    public function index()
    {
        $supplier = Supplier::where('user_id', Auth::id())->first();

        if (!$supplier) {
            return redirect()->route('supplier.profile.edit')
                ->with('warning', 'Please complete your business profile before managing packages and listings.');
        }

        $listings = SupplierListing::with('service.eventType')
            ->where('supplier_id', $supplier->id)
            ->latest('listing_id')
            ->get();

        // Available services configured by this supplier
        $services = $supplier->services()->with('eventType')->get();

        return view('supplier.listings.index', compact('supplier', 'listings', 'services'));
    }

    /**
     * Store a newly created package listing.
     */
    public function store(Request $request)
    {
        $supplier = Supplier::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,service_id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0|max:99999999',
            'price_type' => 'required|in:total_package,per_person,per_hour,per_day',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_url' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $validated;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('listings/images', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        SupplierListing::create(array_merge($data, [
            'supplier_id' => $supplier->id,
        ]));

        return redirect()->route('supplier.listings.index')
            ->with('success', "Package listing '{$validated['title']}' created successfully.");
    }

    /**
     * Update an existing package listing.
     */
    public function update(Request $request, int $id)
    {
        $supplier = Supplier::where('user_id', Auth::id())->firstOrFail();

        $listing = SupplierListing::where('listing_id', $id)
            ->where('supplier_id', $supplier->id)
            ->firstOrFail();

        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,service_id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0|max:99999999',
            'price_type' => 'required|in:total_package,per_person,per_hour,per_day',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_url' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $validated;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('listings/images', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $listing->update($data);

        return redirect()->route('supplier.listings.index')
            ->with('success', "Package '{$listing->title}' updated successfully.");
    }

    /**
     * Toggle listing availability status (active/inactive).
     */
    public function toggle(int $id)
    {
        $supplier = Supplier::where('user_id', Auth::id())->firstOrFail();

        $listing = SupplierListing::where('listing_id', $id)
            ->where('supplier_id', $supplier->id)
            ->firstOrFail();

        $listing->status = ($listing->status === 'active') ? 'inactive' : 'active';
        $listing->save();

        return redirect()->route('supplier.listings.index')
            ->with('success', "Listing availability updated to {$listing->status}.");
    }

    /**
     * Remove a package listing.
     */
    public function destroy(int $id)
    {
        $supplier = Supplier::where('user_id', Auth::id())->firstOrFail();

        $listing = SupplierListing::where('listing_id', $id)
            ->where('supplier_id', $supplier->id)
            ->firstOrFail();

        $listing->delete();

        return redirect()->route('supplier.listings.index')
            ->with('success', 'Listing package removed successfully.');
    }
}
