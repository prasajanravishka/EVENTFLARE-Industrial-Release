<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store or update a customer feedback rating for a supplier on a booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|string|exists:bookings,BookingID',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'nullable|string|max:150',
            'review_text' => 'nullable|string|max:2000',
        ]);

        $userId = Auth::id();

        // Verify the booking belongs to this user
        $booking = Booking::where('BookingID', $validated['booking_id'])
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhere('user_name', Auth::user()->username);
            })
            ->firstOrFail();

        // Save rating (or update if already reviewed)
        Rating::updateOrCreate(
            [
                'booking_id' => $validated['booking_id'],
                'user_id' => $userId,
                'supplier_id' => $validated['supplier_id'],
            ],
            [
                'rating' => $validated['rating'],
                'review_title' => $validated['review_title'] ?? null,
                'review_text' => $validated['review_text'] ?? null,
                'admin_status' => 'approved',
            ]
        );

        return back()->with('success', 'Thank you! Your feedback and rating have been recorded.');
    }
}
