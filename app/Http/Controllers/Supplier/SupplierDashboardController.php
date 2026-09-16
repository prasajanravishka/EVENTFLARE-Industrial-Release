<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\BookingService;
use App\Models\Rating;
use App\Models\Supplier;
use App\Models\SupplierListing;
use Illuminate\Support\Facades\Auth;

class SupplierDashboardController extends Controller
{
    /**
     * Display the supplier command center dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->first();

        $listingCount = 0;
        $ratingAvg = 0.0;
        $ratingCount = 0;
        $reviews = collect();
        $assignedBookingsCount = 0;

        if ($supplier) {
            $listingCount = SupplierListing::where('supplier_id', $supplier->id)->count();

            // Fetch approved customer reviews
            $reviews = Rating::with(['user', 'booking'])
                ->where('supplier_id', $supplier->id)
                ->where('admin_status', 'approved')
                ->latest()
                ->get();

            $ratingCount = $reviews->count();
            if ($ratingCount > 0) {
                $ratingAvg = round($reviews->avg('rating'), 1);
            }

            // Count assigned client bookings
            $assignedBookingsCount = BookingService::where('supplier_id', $supplier->id)->count();
        }

        return view('supplier.dashboard', compact(
            'supplier',
            'listingCount',
            'ratingAvg',
            'ratingCount',
            'reviews',
            'assignedBookingsCount'
        ));
    }
}
