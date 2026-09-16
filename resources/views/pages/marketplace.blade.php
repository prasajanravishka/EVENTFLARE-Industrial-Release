@extends('layouts.eventflare')

@section('title', 'Supplier Directory & Package Marketplace — EVENTFLARE')

@section('content')
<div style="max-width: 1240px; margin: 0 auto; padding: 40px 24px;">

    <!-- Header & Headline -->
    <div style="text-align: center; max-width: 760px; margin: 0 auto 40px auto;">
        <span style="background: rgba(139, 92, 246, 0.1); color: var(--primary); font-size: 12px; font-weight: 800; padding: 6px 16px; border-radius: 20px; text-transform: uppercase;">
            <i class="fas fa-search-dollar"></i> Curated Sri Lankan Event Vendors
        </span>
        <h1 style="font-size: 38px; font-weight: 900; color: var(--text-heading); margin-top: 14px; margin-bottom: 12px;">
            Find Verified Packages & Event Artists
        </h1>
        <p style="color: var(--text-muted); font-size: 15px; line-height: 1.6;">
            Compare fixed-cost packages and hourly rate cards from verified sound engineers, poruwa artists, banquet hotels, and wedding photographers across Sri Lanka.
        </p>
    </div>

    <!-- Search & Filter Bar Grid -->
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: 32px; align-items: start;">

        <!-- Filter Sidebar -->
        <div class="glass-card" style="padding: 24px; border-radius: 18px; position: sticky; top: 90px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin: 0;">
                    <i class="fas fa-sliders-h" style="color: var(--primary);"></i> Filters
                </h3>
                <a href="{{ route('marketplace.index') }}" style="font-size: 12px; color: var(--primary); font-weight: 700; text-decoration: none;">Clear All</a>
            </div>

            <form method="GET" action="{{ route('marketplace.index') }}">
                <!-- Keyword Query -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label" for="q" style="font-size: 12px; font-weight: 700;">Keyword Search</label>
                    <input type="text" id="q" name="q" class="form-input" value="{{ $q }}" placeholder="e.g. Poruwa, DJ, Lights..." style="padding: 9px 12px; font-size: 13px;">
                </div>

                <!-- Event Category Filter -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label" for="event_type" style="font-size: 12px; font-weight: 700;">Event Type</label>
                    <select id="event_type" name="event_type" class="form-input" style="padding: 9px 12px; font-size: 13px;">
                        <option value="">All Event Occasions</option>
                        @foreach($eventTypes as $et)
                            <option value="{{ $et->event_type_id }}" {{ (string)$eventTypeFilter === (string)$et->event_type_id ? 'selected' : '' }}>
                                {{ $et->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Location Filter -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label" for="location" style="font-size: 12px; font-weight: 700;">Operating Region</label>
                    <input type="text" id="location" name="location" class="form-input" value="{{ $location }}" placeholder="e.g. Colombo, Kandy, Galle" style="padding: 9px 12px; font-size: 13px;">
                </div>

                <!-- Price Range Filter -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label" style="font-size: 12px; font-weight: 700;">Budget Range (LKR)</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <input type="number" name="min_price" value="{{ $minPrice }}" placeholder="Min" class="form-input" style="padding: 8px; font-size: 12px;">
                        <input type="number" name="max_price" value="{{ $maxPrice }}" placeholder="Max" class="form-input" style="padding: 8px; font-size: 12px;">
                    </div>
                </div>

                <!-- Sort Direction -->
                <div style="margin-bottom: 24px;">
                    <label class="form-label" for="sort" style="font-size: 12px; font-weight: 700;">Sort By</label>
                    <select id="sort" name="sort" class="form-input" style="padding: 9px 12px; font-size: 13px;">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Newest Listed</option>
                        <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 11px; font-size: 13px; font-weight: 800; border-radius: 12px;">
                    Apply Filters
                </button>
            </form>
        </div>

        <!-- Listings Content Area -->
        <div>
            <!-- Active Filter Chips & Result Counter -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                <div style="font-size: 14px; font-weight: 700; color: var(--text-heading);">
                    Showing {{ $listings->total() }} available packages
                </div>
            </div>

            @if($listings->isEmpty())
                <div class="glass-card" style="text-align: center; padding: 60px 20px; border-radius: 18px;">
                    <div style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;">
                        <i class="fas fa-search-minus"></i>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-bottom: 8px;">No matching packages found</h3>
                    <p style="color: var(--text-muted); font-size: 14px; max-width: 440px; margin: 0 auto 20px auto;">
                        Try broadening your search keywords or removing price filters to discover more supplier packages.
                    </p>
                    <a href="{{ route('marketplace.index') }}" class="btn btn-secondary" style="padding: 10px 20px; border-radius: 12px;">
                        Reset All Filters
                    </a>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; margin-bottom: 30px;">
                    @foreach($listings as $item)
                        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between; border-radius: 18px; padding: 22px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;">
                            <div>
                                @if($item->image_url)
                                    <div style="margin: -22px -22px 16px -22px; height: 160px; overflow: hidden; background: #f1f5f9;">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @endif

                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; gap: 8px;">
                                    <span style="background: rgba(139, 92, 246, 0.1); color: var(--primary); font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 12px; text-transform: uppercase;">
                                        {{ $item->service->service_name ?? 'Service' }}
                                    </span>
                                    <span style="font-size: 18px; font-weight: 900; color: #059669;">
                                        LKR {{ number_format($item->price) }}
                                        <small style="font-size: 11px; font-weight: 600; color: var(--text-muted); display: block; text-align: right;">
                                            / {{ str_replace('_', ' ', $item->price_type) }}
                                        </small>
                                    </span>
                                </div>

                                <h3 style="font-size: 17px; font-weight: 800; color: var(--text-heading); margin-bottom: 8px; line-height: 1.3;">
                                    {{ $item->title }}
                                </h3>

                                <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 14px;">
                                    {{ Str::limit($item->description, 110) }}
                                </p>

                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                    @if($item->supplier->logo_url)
                                        <img src="{{ $item->supplier->logo_url }}" alt="" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <div style="width: 24px; height: 24px; border-radius: 50%; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800;">
                                            {{ substr($item->supplier->business_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span style="font-size: 13px; font-weight: 700; color: var(--text-heading);">
                                        {{ $item->supplier->business_name }}
                                    </span>
                                </div>

                                <div style="display: flex; gap: 12px; font-size: 11px; color: var(--text-muted); margin-bottom: 16px;">
                                    @if($item->supplier->location)
                                        <span><i class="fas fa-map-marker-alt" style="color: #ec4899;"></i> {{ $item->supplier->location }}</span>
                                    @endif
                                    @if($item->capacity)
                                        <span><i class="fas fa-users"></i> Up to {{ $item->capacity }} pax</span>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('booking.create', ['event' => $item->service->eventType->type_name ?? 'Wedding']) }}" class="btn btn-outline" style="border: 1px solid var(--primary); font-size: 12px; font-weight: 800; text-align: center; border-radius: 12px; padding: 8px;">
                                Reserve in Booking
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div style="margin-top: 20px;">
                    {{ $listings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
