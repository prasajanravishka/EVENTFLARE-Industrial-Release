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