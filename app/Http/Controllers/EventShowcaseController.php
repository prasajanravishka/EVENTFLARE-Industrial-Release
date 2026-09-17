<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\Service;
use App\Models\SupplierListing;
use App\Services\EventShowcaseData;
use Illuminate\Http\Request;

class EventShowcaseController extends Controller
{
    private function buildShowcasePayload(string $eventTypeName): array
    {
        $eventType = EventType::where('type_name', $eventTypeName)->first();
        $services = Service::where('event_type_id', $eventType?->event_type_id)
            ->with(['suppliers', 'listings' => function($q) { $q->where('status', 'active')->with('supplier'); }])
            ->orderBy('priority_rank')
            ->get();

        $packages = SupplierListing::whereHas('service', function($q) use ($eventType) {
                $q->where('event_type_id', $eventType?->event_type_id);
            })
            ->where('status', 'active')
            ->with(['supplier', 'service'])
            ->orderBy('listing_id', 'asc')
            ->get();

        $config = EventShowcaseData::getCategoryData($eventTypeName);

        $catTag = match(strtolower(trim($eventTypeName))) {
            'weddings', 'wedding' => 'wedding',
            'dj parties', 'dj-parties', 'dj' => 'dj',
            'birthdays', 'birthday' => 'birthday',
            'hotel venues', 'hotel-venues', 'hotel' => 'hotel',
            'get togethers', 'get-together', 'reunions' => 'gettogether',
            default => 'wedding'
        };

        $dbCaseStudies = \App\Models\CaseStudy::where(function($q) use ($eventType, $catTag) {
            if ($eventType) {
                $q->where('event_type_id', $eventType->event_type_id);
            }
            $q->orWhere('category_tag', $catTag);
        })
        ->where('is_active', true)
        ->orderBy('display_order', 'asc')
        ->get();

        if ($dbCaseStudies->isNotEmpty()) {
            $config['case_studies'] = $dbCaseStudies->map(function($cs) {
                return [
                    'id' => 'cs-' . $cs->id,
                    'title' => $cs->title,
                    'category' => $cs->category_tag,
                    'category_lbl' => $cs->category_label ?? ucfirst($cs->category_tag),
                    'venue' => $cs->venue,
                    'date' => $cs->event_date,
                    'guests' => $cs->guests_count,
                    'image' => $cs->image_url,
                    'tag' => $cs->tagline,
                    'summary' => $cs->summary,
                    'services' => $cs->services_delivered ?? [],
                    'quote' => $cs->quote,
                    'client' => $cs->client_name,
                ];
            })->toArray();
        }

        if ($eventType?->accent_color) {
            $config['theme_color'] = $eventType->accent_color;
        }

        return compact('eventType', 'services', 'packages', 'config');
    }

    public function weddings()
    {
        return view('events.weddings', $this->buildShowcasePayload('Weddings'));
    }

    public function djParties()
    {
        return view('events.dj-parties', $this->buildShowcasePayload('DJ Parties'));
    }

    public function birthdays()
    {
        return view('events.birthdays', $this->buildShowcasePayload('Birthdays'));
    }

    public function hotels()
    {
        return view('events.hotels', $this->buildShowcasePayload('Hotel Venues'));
    }

    public function getTogether()
    {
        return view('events.get-together', $this->buildShowcasePayload('Get Togethers'));
    }
}