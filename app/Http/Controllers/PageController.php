<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\ContactMessage;
use App\Models\EventType;
use App\Models\Rating;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $reviews = Rating::with(['user', 'supplier'])
            ->where('admin_status', 'approved')
            ->where('rating', '>=', 4)
            ->latest()
            ->take(6)
            ->get();

        $eventTypes = EventType::active()->withCount('services')->orderBy('event_type_id')->get();
        $supplierCount = Supplier::count();
        $popularLocations = ['Colombo', 'Kandy', 'Galle', 'Negombo', 'Bentota', 'Nuwara Eliya', 'Gampaha', 'Kalutara'];

        // Gather executed celebrations & case studies from database
        $dbCaseStudies = CaseStudy::active()->featured()->with('eventType')->orderBy('display_order', 'asc')->get();

        $allCaseStudies = [];
        if ($dbCaseStudies->isNotEmpty()) {
            foreach ($dbCaseStudies as $cs) {
                $catName = $cs->eventType?->type_name ?? $cs->category_label ?? 'Celebration';
                $catTag = strtolower(trim($cs->category_tag));

                $showcaseRoute = match($catTag) {
                    'wedding', 'weddings' => route('events.weddings'),
                    'dj', 'dj-parties', 'dj parties' => route('events.dj-parties'),
                    'birthday', 'birthdays' => route('events.birthdays'),
                    'hotel', 'hotels', 'hotel-venues' => route('events.hotels'),
                    'gettogether', 'get-together', 'get togethers' => route('events.get-together'),
                    default => route('events.index')
                };

                $allCaseStudies[] = [
                    'id' => 'cs-' . $cs->id,
                    'title' => $cs->title,
                    'category' => $cs->category_tag,
                    'category_lbl' => $cs->category_label ?? $catName,
                    'category_name' => $catName,
                    'category_filter' => $cs->category_tag,
                    'venue' => $cs->venue,
                    'date' => $cs->event_date,
                    'guests' => $cs->guests_count,
                    'image' => $cs->image_url,
                    'tag' => $cs->tagline,
                    'summary' => $cs->summary,
                    'services' => $cs->services_delivered ?? [],
                    'quote' => $cs->quote,
                    'client' => $cs->client_name,
                    'showcase_route' => $showcaseRoute,
                    'booking_route' => route('booking.create', ['event' => $catName]),
                ];
            }
        } else {
            // Fallback to static EventShowcaseData if table is empty
            foreach (['Weddings', 'DJ Parties', 'Birthdays', 'Hotel Venues', 'Get Togethers'] as $catName) {
                $catConfig = \App\Services\EventShowcaseData::getCategoryData($catName);
                if (!empty($catConfig['case_studies'])) {
                    foreach ($catConfig['case_studies'] as $cs) {
                        $cs['category_name'] = $catName;
                        $cs['category_filter'] = match($catName) {
                            'Weddings' => 'wedding',
                            'DJ Parties' => 'dj',
                            'Birthdays' => 'birthday',
                            'Hotel Venues' => 'hotel',
                            'Get Togethers' => 'gettogether',
                            default => 'wedding'
                        };
                        $cs['showcase_route'] = match($catName) {
                            'Weddings' => route('events.weddings'),
                            'DJ Parties' => route('events.dj-parties'),
                            'Birthdays' => route('events.birthdays'),
                            'Hotel Venues' => route('events.hotels'),
                            'Get Togethers' => route('events.get-together'),
                            default => route('events.weddings')
                        };
                        $cs['booking_route'] = route('booking.create', ['event' => $catName]);
                        $allCaseStudies[] = $cs;
                    }
                }
            }
        }

        return view('pages.home', compact('reviews', 'eventTypes', 'supplierCount', 'popularLocations', 'allCaseStudies'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function events()
    {
        $eventTypes = EventType::active()->with(['services'])->get();

        $categoryMeta = [
            'Weddings' => [
                'slug' => 'weddings',
                'route' => 'events.weddings',
                'booking_param' => 'Weddings',
                'image' => 'assets/images/weding.jpg',
                'badge' => 'Royal Ceremonies',
                'tagline' => 'Poruwa, Kandyan Dancers, Mandaps & Luxury Banquets',
                'color' => '#ec4899',
                'accent_gradient' => 'linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%)',
            ],
            'DJ Parties' => [
                'slug' => 'dj-parties',
                'route' => 'events.dj-parties',
                'booking_param' => 'DJ Parties',
                'image' => 'assets/images/dj.jpg',
                'badge' => 'Intelligent Audio & Lighting',
                'tagline' => 'JBL Line-Arrays, Strobe Lights, Headline DJs & Mixology Bars',
                'color' => '#8b5cf6',
                'accent_gradient' => 'linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%)',
            ],
            'Birthdays' => [
                'slug' => 'birthdays',
                'route' => 'events.birthdays',
                'booking_param' => 'Birthdays',
                'image' => 'assets/images/cake.jpg',
                'badge' => 'Milestones & Themes',
                'tagline' => 'Artisan Fondant Cakes, Balloon Arches & Magic Entertainers',
                'color' => '#f59e0b',
                'accent_gradient' => 'linear-gradient(135deg, #f59e0b 0%, #ec4899 100%)',
            ],
            'Hotel Venues' => [
                'slug' => 'hotel-venues',
                'route' => 'events.hotels',
                'booking_param' => 'Hotel Venues',
                'image' => 'assets/images/hotel.jpg',
                'badge' => '5-Star Hospitality',
                'tagline' => 'Grand Crystal Ballrooms, Beachfront Lawns & Valet Parking',
                'color' => '#3b82f6',
                'accent_gradient' => 'linear-gradient(135deg, #3b82f6 0%, #10b981 100%)',
            ],
            'Get Togethers' => [
                'slug' => 'get-together',
                'route' => 'events.get-together',
                'booking_param' => 'Get Togethers',
                'image' => 'assets/images/evnt.jpg',
                'badge' => 'Reunions & Mixers',
                'tagline' => 'Live Charcoal BBQs, Acoustic Bands & Lakeside Villa Lawns',
                'color' => '#10b981',
                'accent_gradient' => 'linear-gradient(135deg, #10b981 0%, #f59e0b 100%)',
            ],
        ];

        $metrics = [
            'categories_count' => $eventTypes->count(),
            'services_count'   => \App\Models\Service::count(),
            'suppliers_count'  => Supplier::count(),
            'avg_rating'       => '4.9 ★',
        ];

        return view('pages.events', compact(
            'eventTypes',
            'categoryMeta',
            'metrics'
        ));
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:50'],
            'lastname'  => ['required', 'string', 'max:50'],
            'email'     => ['required', 'email', 'max:100'],
            'phone'     => ['required', 'string', 'max:20'],
            'message'   => ['required', 'string', 'max:2000'],
        ]);

        $contactMessage = ContactMessage::create($validated);

        // Dispatch inquiry notification email to admin desk
        try {
            $adminEmail = config('mail.from.address', 'admin@eventflare.lk');
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\NewContactInquiryMail($contactMessage));
        } catch (\Throwable $mailErr) {
            \Illuminate\Support\Facades\Log::warning("Failed to send contact inquiry notification: " . $mailErr->getMessage());
        }

        return redirect()->to(url('/#contact'))->with('success', 'Thank you! Your inquiry has been sent successfully. Our concierge team will reach out shortly.');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}