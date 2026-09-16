@extends('layouts.eventflare')

@section('title', 'Royal Weddings & Poruwa Ceremonies — EVENTFLARE')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    <!-- Hero Header -->
    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 40px; align-items: center; margin-bottom: 60px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(236, 72, 153, 0.1); color: #ec4899; padding: 6px 16px; border-radius: 30px; font-size: 13px; font-weight: 700; margin-bottom: 16px;">
                <i class="fas fa-ring"></i> Royal Weddings Portfolio
            </div>
            <h1 style="font-size: 40px; font-weight: 900; color: var(--text-heading); margin-bottom: 14px; line-height: 1.2;">
                Royal Poruwa Ceremonies & Grand Receptions
            </h1>
            <p style="color: var(--text-muted); font-size: 16px; line-height: 1.7; margin-bottom: 24px;">
                From traditional Kandyan Ves dancer processions to fresh lotus Poruwas and coastal lawn receptions, explore our verified catalog of bespoke wedding suppliers with upfront pricing.
            </p>
            <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                <a href="{{ route('booking.create', ['event' => 'Wedding']) }}" class="btn btn-primary" style="padding: 13px 26px;">
                    <i class="fas fa-calendar-plus"></i> Book This Event
                </a>
                <a href="{{ route('food-calculator') }}" class="btn btn-secondary" style="padding: 13px 26px;">
                    <i class="fas fa-calculator"></i> Calculate Catering Budget
                </a>
            </div>
        </div>

        <div>
            <div style="height: 320px; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-premium);">
                <img src="{{ asset('assets/images/weding.jpg') }}" alt="Royal Wedding" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=800'">
            </div>
        </div>
    </div>

    <!-- Catalogue of Services & Active Packages -->
    <div style="margin-bottom: 60px;">
        <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 10px;">Available Wedding Services</h2>
        <p style="color: var(--text-muted); font-size: 15px; margin-bottom: 30px;">Itemized services included in our wedding coordination pipeline:</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 50px;">
            @foreach($services as $srv)
                <div class="glass-card" style="padding: 22px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                        <span style="font-size: 12px; font-weight: 700; color: var(--primary); text-transform: uppercase;">
                            Priority #{{ $srv->priority_rank }}
                        </span>
                        @if($srv->is_required)
                            <span style="background: #fee2e2; color: #dc2626; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 12px;">Core Service</span>
                        @endif
                    </div>
                    <h3 style="font-size: 17px; font-weight: 700; margin-bottom: 8px;">{{ $srv->service_name }}</h3>
                    <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 12px;">{{ $srv->description }}</p>
                    <div style="font-size: 12px; color: var(--text-muted);">
                        <i class="fas fa-store"></i> {{ $srv->suppliers->count() }} Accredited Suppliers
                    </div>
                </div>
            @endforeach
        </div>

        <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 10px;">Available Vendor Packages</h2>
        <p style="color: var(--text-muted); font-size: 15px; margin-bottom: 30px;">Transparent pricing from certified suppliers:</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px;">
            @php $hasListings = false; @endphp
            @foreach($services as $srv)
                @foreach($srv->listings as $listing)
                    @php $hasListings = true; @endphp
                    <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                                <span style="background: rgba(139, 92, 246, 0.1); color: var(--primary); font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 12px;">
                                    {{ $srv->service_name }}
                                </span>
                                <span style="font-size: 18px; font-weight: 800; color: #059669;">
                                    LKR {{ number_format($listing->price) }}
                                    <small style="font-size: 11px; color: var(--text-muted); display: block; text-align: right;">{{ str_replace('_', ' ', $listing->price_type) }}</small>
                                </span>
                            </div>
                            <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">{{ $listing->title }}</h3>
                            <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-bottom: 14px;">{{ $listing->description }}</p>
                            <div style="font-size: 13px; font-weight: 600; color: var(--text-heading); margin-bottom: 16px;">
                                <i class="fas fa-building" style="color: var(--primary);"></i> {{ $listing->supplier->business_name }}
                            </div>
                        </div>

                        <a href="{{ route('booking.create', ['event' => 'Wedding']) }}" class="btn btn-outline" style="border: 1px solid var(--primary); font-size: 13px;">
                            Book in Package
                        </a>
                    </div>
                @endforeach
            @endforeach

            @if(!$hasListings)
                <p style="color: var(--text-muted);">No vendor packages currently active in this category.</p>
            @endif
        </div>
    </div>
</div>
@endsection