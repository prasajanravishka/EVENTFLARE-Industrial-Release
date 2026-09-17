<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PlatformFeedback;
use App\Models\Rating;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'rating_quality' => 'nullable|integer|min:1|max:5',
            'rating_punctuality' => 'nullable|integer|min:1|max:5',
            'rating_communication' => 'nullable|integer|min:1|max:5',
            'rating_value' => 'nullable|integer|min:1|max:5',
            'review_title' => 'nullable|string|max:150',
            'review_text' => 'nullable|string|max:2000',
            'photos' => 'nullable|array|max:3',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $userId = Auth::id();

        // Verify the booking belongs to this user
        $booking = Booking::where('BookingID', $validated['booking_id'])
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhere('user_name', Auth::user()->username);
            })
            ->firstOrFail();

        // Handle Photo Uploads
        $existingRating = Rating::where('booking_id', $validated['booking_id'])
            ->where('supplier_id', $validated['supplier_id'])
            ->first();

        $photoPaths = $existingRating && is_array($existingRating->photos) ? $existingRating->photos : [];

        if ($request->hasFile('photos')) {
            $newPhotos = [];
            foreach ($request->file('photos') as $file) {
                if ($file && $file->isValid()) {
                    $fileName = 'review_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('assets/images/reviews');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    $file->move($destinationPath, $fileName);
                    $newPhotos[] = 'assets/images/reviews/' . $fileName;
                }
            }
            if (!empty($newPhotos)) {
                $photoPaths = array_slice(array_merge($photoPaths, $newPhotos), 0, 3);
            }
        }

        // Save rating (or update if already reviewed)
        Rating::updateOrCreate(
            [
                'booking_id' => $validated['booking_id'],
                'user_id' => $userId,
                'supplier_id' => $validated['supplier_id'],
            ],
            [
                'rating' => $validated['rating'],
                'rating_quality' => $validated['rating_quality'] ?? $validated['rating'],
                'rating_punctuality' => $validated['rating_punctuality'] ?? $validated['rating'],
                'rating_communication' => $validated['rating_communication'] ?? $validated['rating'],
                'rating_value' => $validated['rating_value'] ?? $validated['rating'],
                'photos' => !empty($photoPaths) ? $photoPaths : null,
                'review_title' => $validated['review_title'] ?? null,
                'review_text' => $validated['review_text'] ?? null,
                'admin_status' => 'approved',
            ]
        );

        return back()->with('success', 'Thank you! Your verified feedback, ratings, and celebration photos have been recorded.');
    }

    /**
     * Store general platform feedback / NPS score from client.
     */
    public function storePlatformFeedback(Request $request)
    {
        $validated = $request->validate([
            'nps_score' => 'nullable|integer|min:0|max:10',
            'platform_rating' => 'nullable|integer|min:1|max:5',
            'category' => 'nullable|string|max:50',
            'comments' => 'nullable|string|max:2000',
            'booking_id' => 'nullable|string|max:50',
        ]);

        PlatformFeedback::create([
            'user_id' => Auth::id(),
            'booking_id' => $validated['booking_id'] ?? null,
            'nps_score' => $validated['nps_score'] ?? null,
            'platform_rating' => $validated['platform_rating'] ?? 5,
            'category' => $validated['category'] ?? 'general',
            'comments' => $validated['comments'] ?? null,
        ]);

        return back()->with('success', 'Thank you for sharing your experience! Your feedback helps us continually elevate EVENTFLARE celebrations.');
    }

    /**
     * Supplier reply to a customer review.
     */
    public function reply(Request $request, $id)
    {
        $validated = $request->validate([
            'supplier_reply' => 'required|string|max:1500',
        ]);

        $rating = Rating::findOrFail($id);
        $user = Auth::user();

        // Check if user is the supplier or admin
        $supplier = Supplier::where('user_id', $user->id)->first();
        if (!$supplier || $supplier->id !== $rating->supplier_id) {
            if ($user->role !== 'admin') {
                abort(403, 'Unauthorized to reply to this review.');
            }
        }

        $rating->update([
            'supplier_reply' => $validated['supplier_reply'],
            'supplier_replied_at' => now(),
        ]);

        return back()->with('success', 'Your official response has been published alongside the customer review.');
    }
}
