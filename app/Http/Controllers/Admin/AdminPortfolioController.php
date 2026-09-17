<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CaseStudy;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPortfolioController extends Controller
{
    /**
     * Display a listing of portfolio case studies with filters & stats.
     */
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');
        $autofillBooking = $request->query('autofill_booking', '');

        $query = CaseStudy::with(['eventType', 'booking']);

        if ($category !== 'all') {
            $query->where('category_tag', $category);
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        } elseif ($status === 'featured') {
            $query->where('is_featured_home', true);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        $caseStudies = $query->orderBy('display_order', 'asc')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $eventTypes = EventType::orderBy('type_name')->get();

        $stats = [
            'total' => CaseStudy::count(),
            'active' => CaseStudy::where('is_active', true)->count(),
            'featured' => CaseStudy::where('is_featured_home', true)->count(),
            'total_guests' => CaseStudy::sum('guests_count'),
        ];

        $categories = [
            'wedding' => 'Weddings & Poruwa',
            'dj' => 'DJ Parties & Audio',
            'birthday' => 'Birthdays & Themes',
            'hotel' => 'Hotel Venues & Halls',
            'gettogether' => 'Social Mixers & Reunions',
            'corporate' => 'Corporate & Bespoke',
        ];

        $completedBookings = Booking::with(['user', 'services.service', 'services.supplier'])
            ->whereIn('status', ['completed', 'confirmed'])
            ->orderBy('EventDate', 'desc')
            ->get();

        return view('admin.portfolio.index', compact(
            'caseStudies',
            'eventTypes',
            'completedBookings',
            'stats',
            'categories',
            'category',
            'status',
            'search',
            'autofillBooking'
        ));
    }

    /**
     * Retrieve complete booking data formatted for 1-click portfolio case study auto-fill.
     */
    public function bookingData(string $bookingId)
    {
        $booking = Booking::with([
            'user',
            'services.service',
            'services.supplier',
            'ratings'
        ])->where('BookingID', $bookingId)->firstOrFail();

        // Map EventType to category_tag & category_label
        $catTag = match (strtolower(trim($booking->EventType))) {
            'weddings', 'wedding' => 'wedding',
            'dj parties', 'dj-parties', 'dj' => 'dj',
            'birthdays', 'birthday' => 'birthday',
            'hotel venues', 'hotel-venues', 'hotel' => 'hotel',
            'get togethers', 'get-together', 'reunions' => 'gettogether',
            'corporate', 'corporate & bespoke' => 'corporate',
            default => 'wedding'
        };

        $categoryLabel = match ($catTag) {
            'wedding' => 'Royal Weddings',
            'dj' => 'DJ & Audio',
            'birthday' => 'Birthdays & Themes',
            'hotel' => 'Luxury Venues',
            'gettogether' => 'Social Mixers',
            'corporate' => 'Corporate & Bespoke',
            default => ucfirst($catTag)
        };

        // Compile services delivered string: "Service Name: Supplier Business"
        $servicesLines = [];
        foreach ($booking->services as $bs) {
            $srvName = $bs->service->service_name ?? 'Accredited Service';
            $suppName = $bs->supplier->business_name ?? 'Accredited Partner';
            $servicesLines[] = "{$srvName}: {$suppName}";
        }
        $servicesText = implode("\n", $servicesLines);

        // Find client testimonial quote if review was submitted
        $rating = $booking->ratings->first();
        $quote = $rating?->review_text ?? null;
        $clientName = $booking->user_name ?: ($booking->user?->fullname ?: 'Honored Client');

        // Format date
        $formattedDate = $booking->EventDate ? \Carbon\Carbon::parse($booking->EventDate)->format('F d, Y') : null;

        // Suggested Title & Summary
        $suggestedTitle = "{$clientName}’s " . ($booking->EventType ?: 'Celebration') . " at {$booking->Place}";
        $suggestedSummary = "An authentic " . strtolower($booking->EventType ?: 'celebration') . " featuring {$booking->NumberOfGuests} guests successfully executed at {$booking->Place}. Managed end-to-end with accredited Eventflare suppliers ensuring flawless hospitality.";

        // Find corresponding EventType model id
        $eventType = EventType::where('type_name', 'like', "%{$booking->EventType}%")->first();

        return response()->json([
            'success' => true,
            'booking_id' => $booking->BookingID,
            'event_type_id' => $eventType?->event_type_id,
            'title' => $suggestedTitle,
            'client_name' => $clientName,
            'category_tag' => $catTag,
            'category_label' => $categoryLabel,
            'venue' => $booking->Place,
            'event_date' => $formattedDate,
            'guests_count' => $booking->NumberOfGuests,
            'services_input' => $servicesText,
            'quote' => $quote,
            'summary' => $suggestedSummary,
            'tagline' => ($booking->DayNight ? ucfirst($booking->DayNight) . ' Celebration' : 'Curated Experience'),
        ]);
    }

    /**
     * Store a newly created case study.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_type_id' => 'nullable|exists:event_types,event_type_id',
            'booking_id' => 'nullable|string|max:50',
            'category_tag' => 'required|string|max:50',
            'category_label' => 'nullable|string|max:100',
            'venue' => 'required|string|max:255',
            'event_date' => 'nullable|string|max:100',
            'guests_count' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_url' => 'nullable|string|max:500',
            'tagline' => 'nullable|string|max:255',
            'summary' => 'required|string|max:3000',
            'quote' => 'nullable|string|max:1000',
            'client_name' => 'nullable|string|max:150',
            'services_input' => 'nullable|string|max:2000',
            'is_featured_home' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $imageUrl = $validated['image_url'] ?? null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('portfolio', 'public');
            $imageUrl = '/storage/' . $path;
        }

        if (empty($imageUrl)) {
            $imageUrl = 'assets/images/weding.jpg';
        }

        // Parse key: value or newline separated services
        $servicesDelivered = $this->parseServicesInput($request->input('services_input'));

        CaseStudy::create([
            'title' => $validated['title'],
            'event_type_id' => $validated['event_type_id'] ?? null,
            'booking_id' => $validated['booking_id'] ?? null,
            'category_tag' => $validated['category_tag'],
            'category_label' => (!empty($validated['category_label'])) ? $validated['category_label'] : $this->defaultCategoryLabel($validated['category_tag']),
            'venue' => $validated['venue'],
            'event_date' => $validated['event_date'] ?? null,
            'guests_count' => $validated['guests_count'],
            'image_url' => $imageUrl,
            'tagline' => $validated['tagline'] ?? null,
            'summary' => $validated['summary'],
            'quote' => $validated['quote'] ?? null,
            'client_name' => $validated['client_name'] ?? null,
            'services_delivered' => $servicesDelivered,
            'is_featured_home' => $request->boolean('is_featured_home', true),
            'is_active' => $request->boolean('is_active', true),
            'display_order' => $validated['display_order'] ?? 0,
        ]);

        return back()->with('success', "Executed Case Study '{$validated['title']}' created successfully.");
    }

    /**
     * Update an existing case study.
     */
    public function update(Request $request, int $id)
    {
        $caseStudy = CaseStudy::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_type_id' => 'nullable|exists:event_types,event_type_id',
            'booking_id' => 'nullable|string|max:50',
            'category_tag' => 'required|string|max:50',
            'category_label' => 'nullable|string|max:100',
            'venue' => 'required|string|max:255',
            'event_date' => 'nullable|string|max:100',
            'guests_count' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_url' => 'nullable|string|max:500',
            'tagline' => 'nullable|string|max:255',
            'summary' => 'required|string|max:3000',
            'quote' => 'nullable|string|max:1000',
            'client_name' => 'nullable|string|max:150',
            'services_input' => 'nullable|string|max:2000',
            'is_featured_home' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $imageUrl = $caseStudy->image_url;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('portfolio', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $imageUrl = $validated['image_url'];
        }

        $servicesDelivered = $caseStudy->services_delivered;
        if ($request->has('services_input')) {
            $servicesDelivered = $this->parseServicesInput($request->input('services_input'));
        }

        $caseStudy->update([
            'title' => $validated['title'],
            'event_type_id' => $validated['event_type_id'] ?? null,
            'booking_id' => $validated['booking_id'] ?? $caseStudy->booking_id,
            'category_tag' => $validated['category_tag'],
            'category_label' => (!empty($validated['category_label'])) ? $validated['category_label'] : $this->defaultCategoryLabel($validated['category_tag']),
            'venue' => $validated['venue'],
            'event_date' => $validated['event_date'] ?? null,
            'guests_count' => $validated['guests_count'],
            'image_url' => $imageUrl,
            'tagline' => $validated['tagline'] ?? null,
            'summary' => $validated['summary'],
            'quote' => $validated['quote'] ?? null,
            'client_name' => $validated['client_name'] ?? null,
            'services_delivered' => $servicesDelivered,
            'is_featured_home' => $request->boolean('is_featured_home'),
            'is_active' => $request->boolean('is_active'),
            'display_order' => $validated['display_order'] ?? 0,
        ]);

        return back()->with('success', "Case Study '{$caseStudy->title}' updated successfully.");
    }

    /**
     * Toggle active / published status.
     */
    public function toggle(int $id)
    {
        $caseStudy = CaseStudy::findOrFail($id);
        $caseStudy->is_active = !$caseStudy->is_active;
        $caseStudy->save();

        $state = $caseStudy->is_active ? 'Activated' : 'Drafted';
        return back()->with('success', "Case study '{$caseStudy->title}' is now {$state}.");
    }

    /**
     * Toggle homepage carousel featured status.
     */
    public function toggleFeatured(int $id)
    {
        $caseStudy = CaseStudy::findOrFail($id);
        $caseStudy->is_featured_home = !$caseStudy->is_featured_home;
        $caseStudy->save();

        $state = $caseStudy->is_featured_home ? 'Featured on Home' : 'Removed from Home';
        return back()->with('success', "Case study '{$caseStudy->title}' is now {$state}.");
    }

    /**
     * Delete a case study.
     */
    public function destroy(int $id)
    {
        $caseStudy = CaseStudy::findOrFail($id);
        $title = $caseStudy->title;

        // If uploaded file, delete it
        if (str_starts_with($caseStudy->image_url ?? '', '/storage/portfolio/')) {
            $relPath = str_replace('/storage/', '', $caseStudy->image_url);
            Storage::disk('public')->delete($relPath);
        }

        $caseStudy->delete();

        return back()->with('success', "Case study '{$title}' deleted successfully.");
    }

    /**
     * Parse service lines formatted as "Service: Vendor" into an associative array.
     */
    private function parseServicesInput(?string $input): array
    {
        if (empty($input)) {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', trim($input));
        $services = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            if (str_contains($line, ':')) {
                [$key, $val] = explode(':', $line, 2);
                $services[trim($key)] = trim($val);
            } else {
                $services[$line] = 'Curated Vendor';
            }
        }

        return $services;
    }

    private function defaultCategoryLabel(string $tag): string
    {
        return match ($tag) {
            'wedding' => 'Royal Weddings',
            'dj' => 'DJ & Audio',
            'birthday' => 'Birthdays & Themes',
            'hotel' => 'Luxury Venues',
            'gettogether' => 'Social Mixers',
            'corporate' => 'Corporate & Bespoke',
            default => ucfirst($tag)
        };
    }
}
