@extends('layouts.eventflare')

@section('title', 'Select Celebration Category — EVENTFLARE')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    <div style="text-align: center; margin-bottom: 50px;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 6px 16px; border-radius: 30px; font-size: 13px; font-weight: 700; margin-bottom: 14px;">
            <i class="fas fa-layer-group"></i> Master Event Portfolio
        </div>
        <h1 style="font-size: 38px; font-weight: 900; color: var(--text-heading); margin-bottom: 12px;">Choose Your Event Category</h1>
        <p style="color: var(--text-muted); font-size: 16px; max-width: 650px; margin: 0 auto;">Select an event type below to browse accredited vendor packages, itemized services, and customize your celebration.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">
        <!-- Weddings -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="height: 180px; border-radius: 14px; overflow: hidden; margin-bottom: 20px; position: relative;">
                    <img src="{{ asset('assets/images/weding.jpg') }}" alt="Weddings" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=600'">
                    <span style="position: absolute; top: 12px; right: 12px; background: rgba(236, 72, 153, 0.9); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">Royal Weddings</span>
                </div>
                <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 10px;">Weddings & Poruwa Ceremonies</h3>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    Traditional Poruwa masters, Ashtaka chanters, Ves dancers, bridal floral decors, gourmet banquet catering, and cinematic 4K drone videography.
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('events.weddings') }}" class="btn btn-outline" style="flex: 1; border: 1px solid #e2e8f0; font-size: 13px;">View Showcase</a>
                <a href="{{ route('booking.create', ['event' => 'Wedding']) }}" class="btn btn-primary" style="flex: 1; font-size: 13px;">Book Event</a>
            </div>
        </div>

        <!-- DJ Parties -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="height: 180px; border-radius: 14px; overflow: hidden; margin-bottom: 20px; position: relative;">
                    <img src="{{ asset('assets/images/dj.jpg') }}" alt="DJ Parties" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600'">
                    <span style="position: absolute; top: 12px; right: 12px; background: rgba(139, 92, 246, 0.9); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">Club Beats</span>
                </div>
                <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 10px;">DJ Parties & Concert Audio</h3>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    JBL line-array sound systems, intelligent moving heads, strobe lights, headline EDM/commercial DJs, crowd control, and mobile mixology cocktail bars.
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('events.dj-parties') }}" class="btn btn-outline" style="flex: 1; border: 1px solid #e2e8f0; font-size: 13px;">View Showcase</a>
                <a href="{{ route('booking.create', ['event' => 'DJ Party']) }}" class="btn btn-primary" style="flex: 1; font-size: 13px;">Book Event</a>
            </div>
        </div>

        <!-- Birthdays -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="height: 180px; border-radius: 14px; overflow: hidden; margin-bottom: 20px; position: relative;">
                    <img src="{{ asset('assets/images/cake.jpg') }}" alt="Birthdays" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=600'">
                    <span style="position: absolute; top: 12px; right: 12px; background: rgba(245, 158, 11, 0.9); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">Milestones</span>
                </div>
                <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 10px;">Birthdays & Anniversaries</h3>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    Artisan sculpted fondant cakes, pastel balloon garlands, kids entertainers, cartoon mascot appearances, sweet dessert tables, and themed catering.
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('events.birthdays') }}" class="btn btn-outline" style="flex: 1; border: 1px solid #e2e8f0; font-size: 13px;">View Showcase</a>
                <a href="{{ route('booking.create', ['event' => 'Birthday']) }}" class="btn btn-primary" style="flex: 1; font-size: 13px;">Book Event</a>
            </div>
        </div>

        <!-- Hotel Venues -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="height: 180px; border-radius: 14px; overflow: hidden; margin-bottom: 20px; position: relative;">
                    <img src="{{ asset('assets/images/hotel.jpg') }}" alt="Hotel Venues" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600'">
                    <span style="position: absolute; top: 12px; right: 12px; background: rgba(59, 130, 246, 0.9); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">Luxury Venues</span>
                </div>
                <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 10px;">5-Star Hotel Venues & Halls</h3>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    Grand crystal ballrooms, beachfront lawns, international buffet menus, luxury guest room blocks, bridal changing suites, and ample secure valet parking.
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('events.hotels') }}" class="btn btn-outline" style="flex: 1; border: 1px solid #e2e8f0; font-size: 13px;">View Showcase</a>
                <a href="{{ route('booking.create', ['event' => 'Hotel Venue']) }}" class="btn btn-primary" style="flex: 1; font-size: 13px;">Book Event</a>
            </div>
        </div>

        <!-- Get-Togethers -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="height: 180px; border-radius: 14px; overflow: hidden; margin-bottom: 20px; position: relative;">
                    <img src="{{ asset('assets/images/evnt.jpg') }}" alt="Get-Togethers" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=600'">
                    <span style="position: absolute; top: 12px; right: 12px; background: rgba(16, 185, 129, 0.9); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">Social Mixers</span>
                </div>
                <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 10px;">Social Reunions & Get-Togethers</h3>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    Casual garden parties, alumni reunions, live charcoal BBQ skewer setups, acoustic guitar sets, canopy marquee rentals, and lawn game packages.
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('events.get-together') }}" class="btn btn-outline" style="flex: 1; border: 1px solid #e2e8f0; font-size: 13px;">View Showcase</a>
                <a href="{{ route('booking.create', ['event' => 'Get Together']) }}" class="btn btn-primary" style="flex: 1; font-size: 13px;">Book Event</a>
            </div>
        </div>
    </div>
</div>
@endsection