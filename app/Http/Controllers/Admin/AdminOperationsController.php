<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\ContactMessage;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $eventTypes = EventType::with('services')->orderBy('event_type_id')->get();
        return view('admin.event-types.index', compact('eventTypes'));
    }

    public function storeEventType(Request $request)
    {
        $validated = $request->validate([
            'type_name' => 'required|string|max:100|unique:event_types,type_name',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ]);

        EventType::create([
            'type_name' => $validated['type_name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', "Event Category '{$validated['type_name']}' created successfully.");
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'event_type_id' => 'required|integer|exists:event_types,event_type_id',
            'service_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'priority_rank' => 'required|integer|min:1',
            'is_required' => 'nullable|boolean',
        ]);

        Service::create([
            'event_type_id' => $validated['event_type_id'],
            'service_name' => $validated['service_name'],
            'description' => $validated['description'] ?? '',
            'priority_rank' => $validated['priority_rank'],
            'is_required' => $request->has('is_required'),
        ]);

        return back()->with('success', "Service '{$validated['service_name']}' added to category catalog.");
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
