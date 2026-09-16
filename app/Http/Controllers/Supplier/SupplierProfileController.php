<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\EventType;
use App\Models\Service;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierProfileController extends Controller
{
    /**
     * Show the supplier profile edit view.
     */
    public function edit()
    {
        $user = Auth::user();
        $supplier = Supplier::with('services')->where('user_id', $user->id)->first();
        $eventTypes = EventType::with('services')->active()->get();

        return view('supplier.profile', compact('supplier', 'eventTypes'));
    }

    /**
     * Update or create the supplier profile and sync services.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:150',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:2000',
            'contact_phone' => 'required|string|max:50',
            'location' => 'required|string|max:150',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'services' => 'nullable|array',
            'services.*' => 'integer|exists:services,service_id',
        ]);

        $user = Auth::user();

        DB::beginTransaction();
        try {
            $updateData = [
                'business_name' => $validated['business_name'],
                'category' => $validated['category'] ?? 'Event Services Specialist',
                'description' => $validated['description'] ?? null,
                'contact_phone' => $validated['contact_phone'],
                'location' => $validated['location'],
            ];

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('suppliers/logos', 'public');
                $updateData['logo_url'] = '/storage/' . $path;
            }

            $supplier = Supplier::updateOrCreate(
                ['user_id' => $user->id],
                $updateData
            );

            // Sync supplier services
            if (isset($validated['services'])) {
                $supplier->services()->sync($validated['services']);
            } else {
                $supplier->services()->detach();
            }

            DB::commit();

            return redirect()->route('supplier.profile.edit')
                ->with('success', 'Supplier business profile and service offerings updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }
}
