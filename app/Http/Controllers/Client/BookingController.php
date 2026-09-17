<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\EventExtra;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display booking creation form / wizard launcher.
     */
    public function create(Request $request)
    {
        $eventTypes = EventType::active()->orderBy('event_type_id')->get();
        $preEvent = $request->query('event', '');
        $preVenue = $request->query('venue', '');
        $preGuests = (int) $request->query('guests', 0);
        $prePackage = $request->query('package', '');
        $preDetails = $request->query('details', '');
        $preStyle = $request->query('style', '');

        if (!empty($prePackage) && empty($preDetails)) {
            $preDetails = 'Interested in Package: ' . $prePackage;
        }

        if (!empty($preStyle) && !str_contains($preDetails, 'Style:')) {
            $styleLabel = 'Preferred Style/Theme: ' . ucfirst(str_replace('-', ' ', $preStyle));
            $preDetails = !empty($preDetails) ? $preDetails . ' | ' . $styleLabel : $styleLabel;
        }

        // If specific category is requested, load itemized services and suppliers
        $selectedType = null;
        $services = collect();
        if (!empty($preEvent)) {
            $selectedType = EventType::where('type_name', 'like', "%{$preEvent}%")->first();
            if ($selectedType) {
                $services = Service::with(['listings.supplier', 'suppliers'])
                    ->where('event_type_id', $selectedType->event_type_id)
                    ->orderBy('priority_rank')
                    ->get();
            }
        }

        // Dedicated Wedding Tiers & Cultural Styles configuration
        $cateringTiers = [
            'Platinum' => [
                'name' => 'Platinum Grand Tier',
                'rate' => 6500.00,
                'tagline' => '5-Course International Gourmet Buffet & Live Themed Carving Stations',
                'highlights' => ['Unlimited Welcome Mocktails & Fresh Fruit Carafes', '3 Live Show-Cooking Stalls (Mongolian & Roast Ribs)', '12 Artisanal Desserts & Belgian Chocolate Fountain', 'Dedicated Head Waiter & White Glove Table Service'],
                'badge' => 'Most Popular',
            ],
            'Executive' => [
                'name' => 'Executive Royal Tier',
                'rate' => 4800.00,
                'tagline' => '3-Course Delicacy Buffet with Curated Ceylon & Continental Specialities',
                'highlights' => ['Welcome Fruit Punch & Chilled Canapés', '2 Live Action Stations (Satay & Pasta Corner)', '8 Handcrafted Tropical & French Pastries', 'Trained Uniformed Banquet Captains'],
                'badge' => 'Best Value',
            ],
            'Cocktail' => [
                'name' => 'Twilight Cocktail Tier',
                'rate' => 3200.00,
                'tagline' => 'Gourmet Pass-Around Canapés, Artisan Sliders & Grazing Boards',
                'highlights' => ['14 Signature Pass-Around Finger Food Selections', 'Artisanal European Cheese & Charcuterie Board', 'Live Dim Sum & Yakitori Brochette Stations', 'Specialized Mixologist Mocktail Station'],
                'badge' => 'Chic & Light',
            ],
        ];

        $culturalStyles = [
            'Traditional' => [
                'title' => 'Traditional Poruwa',
                'icon' => 'fas fa-landmark',
                'color' => '#f59e0b',
                'desc' => 'Sacred Sinhala cultural rituals, Magul Bera drummers, Jayamangala chants & lotus mandaps.',
            ],
            'Western' => [
                'title' => 'Western Elegance',
                'icon' => 'fas fa-church',
                'color' => '#60a5fa',
                'desc' => 'Contemporary cathedral aisle styling, formal black-tie banquet, champagne toasts & first dance.',
            ],
            'Beach' => [
                'title' => 'Coastal Beachside',
                'icon' => 'fas fa-umbrella-beach',
                'color' => '#34d399',
                'desc' => 'Tropical sunset vows, floral timber canopies, ocean breezes & barefoot luxury ambiance.',
            ],
            'Ballroom' => [
                'title' => 'Grand Luxury Ballroom',
                'icon' => 'fas fa-gem',
                'color' => '#f472b6',
                'desc' => '5-Star hotel grandeur, crystal chandeliers, floral tunnels, and theatrical ambient wash.',
            ],
        ];

        return view('client.bookings.create', compact(
            'eventTypes',
            'preEvent',
            'preVenue',
            'preGuests',
            'prePackage',
            'preDetails',
            'preStyle',
            'selectedType',
            'services',
            'cateringTiers',
            'culturalStyles'
        ));
    }

    /**
     * Store a newly created booking with collision-resistant ID and atomic transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'EventType' => 'required|string|max:100',
            'Place' => 'required|string|max:255',
            'NumberOfGuests' => 'required|integer|min:1|max:50000',
            'EventDate' => 'required|date|after_or_equal:today',
            'DayNight' => 'required|in:Day,Night',
            'FoodPreferences' => 'nullable|string|max:100',
            'catering_tier' => 'nullable|string|max:50',
            'cultural_style' => 'nullable|string|max:50',
            'couple_names' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:30',
            'contact_email' => 'nullable|email|max:150',
            'ExtraDetails' => 'nullable|string|max:2000',
            'extra_details' => 'nullable|string|max:2000',
            'equipment' => 'nullable|string|max:255',
            'food_style' => 'nullable|string|max:100',
            'selected_packages' => 'nullable|array',
            'selected_packages.*' => 'nullable|integer',
        ]);

        $user = Auth::user();

        // Determine food preferences & extra details
        $foodPref = $validated['FoodPreferences'] ?? '';
        if (!empty($validated['catering_tier'])) {
            $foodPref = $validated['catering_tier'] . ' Tier';
        }
        if (empty($foodPref)) {
            $foodPref = 'Executive Tier';
        }

        // Consolidated extra details
        $extraDetails = $validated['ExtraDetails'] ?? $validated['extra_details'] ?? '';
        if (!empty($validated['couple_names'])) {
            $prefix = "Couple: " . $validated['couple_names'];
            if (!empty($validated['contact_phone'])) {
                $prefix .= " | Phone: " . $validated['contact_phone'];
            }
            if (!empty($validated['contact_email'])) {
                $prefix .= " | Email: " . $validated['contact_email'];
            }
            $extraDetails = !empty($extraDetails) ? $prefix . " | " . $extraDetails : $prefix;
        }

        // Generate collision-resistant unique Booking ID (BKG-WED-XXXX or BKG-XXXX)
        $isWedding = stripos($validated['EventType'], 'Wed') !== false;
        $bookingId = ($isWedding ? 'BKG-WED-' : 'BKG-') . strtoupper(Str::random(8));

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'BookingID' => $bookingId,
                'user_id' => $user->id,
                'user_name' => $user->username,
                'EventType' => $validated['EventType'],
                'Place' => $validated['Place'],
                'NumberOfGuests' => $validated['NumberOfGuests'],
                'EventDate' => $validated['EventDate'],
                'DayNight' => $validated['DayNight'],
                'FoodPreferences' => $foodPref,
                'ExtraDetails' => $extraDetails ?: null,
                'status' => 'pending',
            ]);

            // Persist optional event extras
            $foodStyle = $validated['food_style'] ?? '';
            if (!empty($validated['cultural_style'])) {
                $foodStyle = $validated['cultural_style'] . ' Wedding';
            }
            if (empty($foodStyle)) {
                $foodStyle = $foodPref;
            }

            EventExtra::create([
                'booking_id' => $bookingId,
                'equipment' => $validated['equipment'] ?? 'Traditional Poruwa Decor, Stage AV & Mood Lighting',
                'food_style' => $foodStyle,
            ]);

            // Persist package selections with dynamic per-person vs flat fee cost
            if (!empty($validated['selected_packages'])) {
                foreach ($validated['selected_packages'] as $serviceId => $listingId) {
                    if (!empty($listingId)) {
                        $listing = \App\Models\SupplierListing::find($listingId);
                        if ($listing) {
                            $unitPrice = (float) $listing->price;
                            $assignedCost = ($listing->price_type === 'per_person')
                                ? ($unitPrice * (int) $validated['NumberOfGuests'])
                                : $unitPrice;

                            BookingService::create([
                                'booking_id' => $bookingId,
                                'service_id' => $serviceId,
                                'supplier_id' => $listing->supplier_id,
                                'listing_id' => $listing->listing_id,
                                'assigned_cost' => $assignedCost,
                                'status' => 'confirmed',
                                'custom_notes' => 'Selected during booking: ' . $listing->title . ' (' . ucfirst(str_replace('_', ' ', $listing->price_type)) . ')',
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            // Dispatch notification email safely to client
            try {
                if ($user = Auth::user()) {
                    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\BookingConfirmationMail($booking));
                }
            } catch (\Throwable $mailErr) {
                \Illuminate\Support\Facades\Log::warning("Failed to send booking confirmation email: " . $mailErr->getMessage());
            }

            return redirect()->route('client.bookings')
                ->with('success', "Reservation successfully created! Your Booking Reference is #{$bookingId}");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Unable to complete reservation: ' . $e->getMessage());
        }
    }

    /**
     * Display client's personal bookings list.
     */
    public function index()
    {
        $userId = Auth::id();
        $username = Auth::user()->username;

        $bookings = Booking::with([
            'extra',
            'services.service',
            'services.supplier',
            'services.listing',
            'ratings',
        ])
        ->where(function ($query) use ($userId, $username) {
            $query->where('user_id', $userId)
                  ->orWhere('user_name', $username);
        })
        ->orderBy('EventDate', 'desc')
        ->get();

        return view('client.bookings.index', compact('bookings'));
    }

    /**
     * Show booking details / dossier modal data.
     */
    public function show(string $id)
    {
        $booking = Booking::with([
            'extra',
            'services.service',
            'services.supplier',
            'services.listing',
            'ratings',
        ])->where('BookingID', $id)
          ->where(function ($query) {
              $query->where('user_id', Auth::id())
                    ->orWhere('user_name', Auth::user()->username);
          })
          ->firstOrFail();

        return view('client.bookings.show', compact('booking'));
    }

    /**
     * Export / Download itinerary and voucher slip as PDF.
     */
    public function pdf(string $id)
    {
        $booking = Booking::with([
            'extra',
            'services.service',
            'services.supplier',
            'services.listing',
            'user',
        ])->where('BookingID', $id)
          ->where(function ($query) {
              $query->where('user_id', Auth::id())
                    ->orWhere('user_name', Auth::user()->username);
          })
          ->firstOrFail();

        $pdf = Pdf::loadView('client.bookings.pdf', compact('booking'));
        $filename = "EVENTFLARE-Reservation-{$booking->BookingID}.pdf";

        return $pdf->download($filename);
    }
}
