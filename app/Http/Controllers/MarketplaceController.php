<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\Supplier;
use App\Models\SupplierListing;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    /**
     * Search and filter marketplace packages and suppliers.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        $eventTypeFilter = $request->input('event_type');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $location = $request->input('location');
        $sort = $request->input('sort', 'latest');

        $query = SupplierListing::with(['supplier.user', 'service.eventType'])
            ->where('status', 'active');

        if (!empty($q)) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhereHas('supplier', function ($sq) use ($q) {
                        $sq->where('business_name', 'like', "%{$q}%")
                           ->orWhere('category', 'like', "%{$q}%");
                    })
                    ->orWhereHas('service', function ($sq) use ($q) {
                        $sq->where('service_name', 'like', "%{$q}%");
                    });
            });
        }

        if (!empty($eventTypeFilter)) {
            $query->whereHas('service.eventType', function ($eq) use ($eventTypeFilter) {
                $eq->where('event_type_id', $eventTypeFilter);
            });
        }

        if (!empty($location)) {
            $query->whereHas('supplier', function ($sq) use ($location) {
                $sq->where('location', 'like', "%{$location}%");
            });
        }

        if (is_numeric($minPrice)) {
            $query->where('price', '>=', (float)$minPrice);
        }

        if (is_numeric($maxPrice)) {
            $query->where('price', '<=', (float)$maxPrice);
        }

        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest('listing_id');
                break;
        }

        $listings = $query->paginate(9)->withQueryString();
        $eventTypes = EventType::active()->orderBy('type_name')->get();
        $locations = Supplier::whereNotNull('location')->distinct()->pluck('location')->filter()->values();

        return view('pages.marketplace', compact('listings', 'eventTypes', 'locations', 'q', 'eventTypeFilter', 'minPrice', 'maxPrice', 'location', 'sort'));
    }
}

