<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Budget;
use App\Models\ContactMessage;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Executive Overview Console.
     */
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'buyers' => User::where('role', 'buyer')->count(),
            'suppliers' => User::where('role', 'supplier')->count(),
            'bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'budget' => (float) Budget::sum('total_budget'),
            'messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'event_types' => EventType::count(),
            'active_event_types' => EventType::where('is_active', true)->count(),
        ];

        // Monthly bookings chart for current year
        $monthlyBookings = Booking::select(
            DB::raw("DATE_FORMAT(EventDate, '%b') as month_label"),
            DB::raw("MONTH(EventDate) as m"),
            DB::raw("COUNT(*) as cnt")
        )
        ->whereYear('EventDate', date('Y'))
        ->groupBy('m', 'month_label')
        ->orderBy('m')
        ->get();

        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = array_fill(0, 12, 0);

        foreach ($monthlyBookings as $mb) {
            $monthIndex = (int)$mb->m - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $chartData[$monthIndex] = (int)$mb->cnt;
            }
        }

        // Status counts
        $statusCounts = [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'in_progress' => Booking::where('status', 'in progress')->orWhere('status', 'in_progress')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        // Recent bookings preview
        $recentBookings = Booking::with('services.supplier')->latest('created_at')->take(6)->get();

        return view('admin.dashboard', compact(
            'stats',
            'chartLabels',
            'chartData',
            'statusCounts',
            'recentBookings'
        ));
    }
}
