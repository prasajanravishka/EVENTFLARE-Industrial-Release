@extends('layouts.eventflare')

@section('title', 'DJ Parties & Concert Sound — EVENTFLARE')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    <!-- Hero Header -->
    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 40px; align-items: center; margin-bottom: 60px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 6px 16px; border-radius: 30px; font-size: 13px; font-weight: 700; margin-bottom: 16px;">
                <i class="fas fa-compact-disc"></i> Electronic & Live Concerts
            </div>
            <h1 style="font-size: 40px; font-weight: 900; color: var(--text-heading); margin-bottom: 14px; line-height: 1.2;">
                DJ Parties & Intelligent Stage Production
            </h1>
            <p style="color: var(--text-muted); font-size: 16px; line-height: 1.7; margin-bottom: 24px;">
                Concert-grade JBL & RCF line array speaker stacks, beam moving heads, haze machines, headline DJ talent, security barricades, and mobile cocktail mixology.
            </p>
            <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                <a href="{{ route('booking.create', ['event' => 'DJ Party']) }}" class="btn btn-primary" style="padding: 13px 26px;">
                    <i class="fas fa-calendar-plus"></i> Book DJ Party
                </a>
            </div>
        </div>

        <div>
            <div style="height: 320px; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-premium);">
                <img src="{{ asset('assets/images/dj.jpg') }}" alt="DJ Party" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=800'">
            </div>
        </div>
    </div>

    <!-- Active Packages -->
    <div>
        <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 10px;">Available Sound & Light Packages</h2>
        <p style="color: var(--text-muted); font-size: 15px; margin-bottom: 30px;">Accredited audiovisual engineers and live performers:</p>

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

                        <a href="{{ route('booking.create', ['event' => 'DJ Party']) }}" class="btn btn-outline" style="border: 1px solid var(--primary); font-size: 13px;">
                            Book in Package
                        </a>
                    </div>
                @endforeach
            @endforeach

            @if(!$hasListings)
                <p style="color: var(--text-muted);">No listings currently active for this event category.</p>
            @endif
        </div>
    </div>
</div>
@endsection