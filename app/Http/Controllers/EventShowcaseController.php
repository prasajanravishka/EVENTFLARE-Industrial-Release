<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\Service;
use App\Models\SupplierListing;
use Illuminate\Http\Request;

class EventShowcaseController extends Controller
{
    public function weddings()
    {
        $eventType = EventType::where('type_name', 'Weddings')->first();
        $services = Service::where('event_type_id', $eventType?->event_type_id)
            ->with(['suppliers', 'listings' => function($q) { $q->where('status', 'active')->with('supplier'); }])
            ->orderBy('priority_rank')
            ->get();

        return view('events.weddings', compact('eventType', 'services'));
    }

    public function djParties()
    {
        $eventType = EventType::where('type_name', 'DJ Parties')->first();
        $services = Service::where('event_type_id', $eventType?->event_type_id)
            ->with(['suppliers', 'listings' => function($q) { $q->where('status', 'active')->with('supplier'); }])
            ->orderBy('priority_rank')
            ->get();

        return view('events.dj-parties', compact('eventType', 'services'));
    }

    public function birthdays()
    {
        $eventType = EventType::where('type_name', 'Birthdays')->first();
        $services = Service::where('event_type_id', $eventType?->event_type_id)
            ->with(['suppliers', 'listings' => function($q) { $q->where('status', 'active')->with('supplier'); }])
            ->orderBy('priority_rank')
            ->get();

        return view('events.birthdays', compact('eventType', 'services'));
    }

    public function hotels()
    {
        $eventType = EventType::where('type_name', 'Hotel Venues')->first();
        $services = Service::where('event_type_id', $eventType?->event_type_id)
            ->with(['suppliers', 'listings' => function($q) { $q->where('status', 'active')->with('supplier'); }])
            ->orderBy('priority_rank')
            ->get();

        return view('events.hotels', compact('eventType', 'services'));
    }

    public function getTogether()
    {
        $eventType = EventType::where('type_name', 'Get Togethers')->first();
        $services = Service::where('event_type_id', $eventType?->event_type_id)
            ->with(['suppliers', 'listings' => function($q) { $q->where('status', 'active')->with('supplier'); }])
            ->orderBy('priority_rank')
            ->get();

        return view('events.get-together', compact('eventType', 'services'));
    }
}