<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    /**
     * Display Client Event Hub & Command Center.
     */
    public function index()
    {
        $userId = Auth::id();
        $username = Auth::user()->username;

        // Metric 1: Active Bookings
        $activeCount = Booking::where(function ($query) use ($userId, $username) {
            $query->where('user_id', $userId)
                  ->orWhere('user_name', $username);
        })
        ->whereIn('status', ['pending', 'in progress', 'confirmed'])
        ->count();

        // Metric 2: Next Event & Days Remaining
        $nextEvent = Booking::where(function ($query) use ($userId, $username) {
            $query->where('user_id', $userId)
                  ->orWhere('user_name', $username);
        })
        ->where('EventDate', '>=', Carbon::today())
        ->whereIn('status', ['pending', 'in progress', 'confirmed'])
        ->orderBy('EventDate', 'asc')
        ->first();

        $daysLeft = null;
        if ($nextEvent && $nextEvent->EventDate) {
            $daysLeft = Carbon::today()->diffInDays($nextEvent->EventDate, false);
            if ($daysLeft < 0) {
                $daysLeft = 0;
            }
        }

        // Metric 3: Assigned Verified Suppliers
        $suppliersCount = BookingService::whereHas('booking', function ($query) use ($userId, $username) {
            $query->where('user_id', $userId)
                  ->orWhere('user_name', $username);
        })
        ->whereNotNull('supplier_id')
        ->distinct('supplier_id')
        ->count('supplier_id');

        // Metric 4: Completed Celebrations
        $completedCount = Booking::where(function ($query) use ($userId, $username) {
            $query->where('user_id', $userId)
                  ->orWhere('user_name', $username);
        })
        ->where('status', 'completed')
        ->count();

        // Recent Bookings (up to 5 for quick access)
        $recentBookings = Booking::with(['services.supplier', 'extra'])
            ->where(function ($query) use ($userId, $username) {
                $query->where('user_id', $userId)
                      ->orWhere('user_name', $username);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('client.dashboard', compact(
            'activeCount',
            'nextEvent',
            'daysLeft',
            'suppliersCount',
            'completedCount',
            'recentBookings'
        ));
    }
}
