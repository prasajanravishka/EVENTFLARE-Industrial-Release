<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Budget;
use App\Models\ContactMessage;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Executive Overview Console.
     */
    public function index()
    {
        $shortageCount = Service::doesntHave('suppliers')->count();

        $stats = [
            'users' => User::count(),
            'buyers' => User::where('role', 'buyer')->count(),
            'suppliers' => User::where('role', 'supplier')->count(),
            'bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'budget' => (float) Budget::sum('total_budget'),
            'food_budget' => (float) Budget::sum('food_budget'),
            'spent_budget' => (float) Budget::sum('total_spent'),
            'remaining_budget' => (float) Budget::sum('remaining_budget'),
            'messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'shortage_count' => $shortageCount,
            'event_types' => EventType::count(),
            'active_event_types' => EventType::where('is_active', true)->count(),
            'portfolio' => \App\Models\CaseStudy::count(),
            'featured_portfolio' => \App\Models\CaseStudy::where('is_featured_home', true)->count(),
        ];

        // Monthly bookings chart for current year
        if (DB::connection()->getDriverName() === 'sqlite') {
            $monthlyBookings = Booking::select(
                DB::raw("strftime('%m', EventDate) as m"),
                DB::raw("COUNT(*) as cnt")
            )
            ->whereRaw("strftime('%Y', EventDate) = ?", [date('Y')])
            ->groupBy('m')
            ->orderBy('m')
            ->get();
        } else {
            $monthlyBookings = Booking::select(
                DB::raw("DATE_FORMAT(EventDate, '%b') as month_label"),
                DB::raw("MONTH(EventDate) as m"),
                DB::raw("COUNT(*) as cnt")
            )
            ->whereYear('EventDate', date('Y'))
            ->groupBy('m', 'month_label')
            ->orderBy('m')
            ->get();
        }

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

        // Category Popularity
        $totalBookingsCount = max(1, Booking::count());
        $categoryPopularity = Booking::select('EventType', DB::raw('COUNT(*) as total'))
            ->groupBy('EventType')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) use ($totalBookingsCount) {
                $item->percentage = round(($item->total / $totalBookingsCount) * 100, 1);
                return $item;
            });

        // Recent customer ratings & endorsements
        $recentRatings = Rating::with(['user', 'supplier'])
            ->latest('id')
            ->take(4)
            ->get();

        // Recent bookings preview
        $recentBookings = Booking::with(['user', 'services.supplier'])->latest('created_at')->take(6)->get();

        return view('admin.dashboard', compact(
            'stats',
            'chartLabels',
            'chartData',
            'statusCounts',
            'recentBookings',
            'categoryPopularity',
            'recentRatings'
        ));
    }
}
