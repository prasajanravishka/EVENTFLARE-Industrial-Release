@extends('layouts.eventflare')

@section('title', 'Client Event Hub — EVENTFLARE')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">

    <!-- Welcome Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                <i class="fas fa-sparkles"></i> Customer Command Center
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: var(--text-heading); margin-bottom: 6px;">
                Welcome back, {{ Auth::user()->fullname ?? Auth::user()->username }}!
            </h1>
            <p style="color: var(--text-muted); font-size: 15px;">Manage your Sri Lankan wedding, milestone party, and corporate reservations in one centralized hub.</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('events.index') }}" class="btn btn-primary" style="padding: 12px 24px; border-radius: 30px; font-weight: 700;">
                <i class="fas fa-plus"></i> New Reservation
            </a>
            <a href="{{ route('client.bookings') }}" class="btn btn-secondary" style="padding: 12px 24px; border-radius: 30px; font-weight: 700;">
                <i class="fas fa-calendar-alt"></i> My Bookings
            </a>
        </div>
    </div>

    <!-- Live Intelligence Metric Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 35px;">
        <!-- Metric 1 -->
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 18px;">
            <div style="width: 54px; height: 54px; border-radius: 14px; background: rgba(139, 92, 246, 0.15); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div style="font-size: 28px; font-weight: 900; color: var(--text-heading); line-height: 1;">{{ $activeCount }}</div>
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600; margin-top: 4px;">Active Bookings</div>
            </div>
        </div>

        <!-- Metric 2 -->
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 18px;">
            <div style="width: 54px; height: 54px; border-radius: 14px; background: rgba(236, 72, 153, 0.15); color: #ec4899; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <div style="font-size: 28px; font-weight: 900; color: var(--text-heading); line-height: 1;">
                    {{ $daysLeft !== null ? $daysLeft . 'd' : '—' }}
                </div>
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600; margin-top: 4px;">Days to Next Event</div>
            </div>
        </div>

        <!-- Metric 3 -->
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 18px;">
            <div style="width: 54px; height: 54px; border-radius: 14px; background: rgba(59, 130, 246, 0.15); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-store"></i>
            </div>
            <div>
                <div style="font-size: 28px; font-weight: 900; color: var(--text-heading); line-height: 1;">{{ $suppliersCount }}</div>
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600; margin-top: 4px;">Contracted Vendors</div>
            </div>
        </div>

        <!-- Metric 4 -->
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 18px;">
            <div style="width: 54px; height: 54px; border-radius: 14px; background: rgba(16, 185, 129, 0.15); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-trophy"></i>
            </div>
            <div>
                <div style="font-size: 28px; font-weight: 900; color: var(--text-heading); line-height: 1;">{{ $completedCount }}</div>
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600; margin-top: 4px;">Completed Celebrations</div>
            </div>
        </div>
    </div>

    <!-- Upcoming Event Spotlight Banner -->
    @if($nextEvent)
        <div class="glass-card" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.12), rgba(236, 72, 153, 0.08)); border: 1px solid rgba(139, 92, 246, 0.3); padding: 28px; margin-bottom: 35px; border-radius: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div>
                    <span style="background: var(--primary); color: #fff; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                        Upcoming Celebration
                    </span>
                    <h3 style="font-size: 24px; font-weight: 800; margin: 10px 0 6px; color: var(--text-heading);">
                        {{ $nextEvent->EventType }} at {{ $nextEvent->Place }}
                    </h3>
                    <p style="color: var(--text-muted); font-size: 14px; margin: 0;">
                        <i class="fas fa-calendar-day" style="color: var(--primary); margin-right: 6px;"></i>
                        {{ \Carbon\Carbon::parse($nextEvent->EventDate)->format('l, F j, Y') }} &bull; {{ $nextEvent->DayNight }} Session &bull; {{ $nextEvent->NumberOfGuests }} Guests
                    </p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('client.bookings.pdf', $nextEvent->BookingID) }}" class="btn btn-secondary" style="border-radius: 25px; padding: 10px 18px; font-size: 13px;">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                    <a href="{{ route('client.bookings.show', $nextEvent->BookingID) }}" class="btn btn-primary" style="border-radius: 25px; padding: 10px 18px; font-size: 13px;">
                        <i class="fas fa-eye"></i> View Itinerary
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Bookings Table & Quick Tools -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; align-items: start;">
        <!-- Recent Reservations -->
        <div class="glass-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-heading); margin: 0;">
                    <i class="fas fa-history" style="color: var(--primary); margin-right: 8px;"></i> Recent Reservations
                </h3>
                <a href="{{ route('client.bookings') }}" style="font-size: 13px; font-weight: 700; color: var(--primary);">View All &rarr;</a>
            </div>

            @if($recentBookings->isEmpty())
                <div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                    <i class="fas fa-calendar-plus" style="font-size: 36px; opacity: 0.4; margin-bottom: 12px; display: block;"></i>
                    <p style="margin-bottom: 14px;">You have no reservations logged yet.</p>
                    <a href="{{ route('events.index') }}" class="btn btn-primary" style="font-size: 13px;">Start Your First Booking</a>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($recentBookings as $b)
                        <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 14px 16px; border-radius: 12px; border: 1px solid #e2e8f0; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <strong style="font-size: 14px; color: var(--text-heading);">#{{ $b->BookingID }}</strong>
                                    <span style="font-size: 12px; color: var(--text-muted);">&bull; {{ $b->EventType }}</span>
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                                    <i class="fas fa-map-marker-alt fa-xs" style="color: #ef4444;"></i> {{ $b->Place }} &bull; {{ \Carbon\Carbon::parse($b->EventDate)->format('M d, Y') }}
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                @php
                                    $st = $b->status ?? 'pending';
                                    $badges = [
                                        'pending' => ['bg' => '#fef3c7', 'color' => '#b45309'],
                                        'confirmed' => ['bg' => '#dcfce7', 'color' => '#15803d'],
                                        'in progress' => ['bg' => '#dbeafe', 'color' => '#1d4ed8'],
                                        'completed' => ['bg' => '#dcfce7', 'color' => '#15803d'],
                                        'cancelled' => ['bg' => '#fee2e2', 'color' => '#b91c1c'],
                                    ];
                                    $badge = $badges[$st] ?? ['bg' => '#f1f5f9', 'color' => '#475569'];
                                @endphp
                                <span style="background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 14px; text-transform: capitalize;">
                                    {{ $st }}
                                </span>
                                <a href="{{ route('client.bookings.show', $b->BookingID) }}" class="btn btn-outline" style="padding: 5px 12px; font-size: 12px; border-radius: 15px; border: 1px solid #cbd5e1;">
                                    Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Quick Planning Utilities -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Food Calculator Teaser -->
            <div class="glass-card" style="padding: 22px;">
                <div style="font-size: 24px; color: #f59e0b; margin-bottom: 10px;">
                    <i class="fas fa-calculator"></i>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 6px;">
                    Food & Catering Calculator
                </h4>
                <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 14px;">
                    Estimate buffet costs, beverage bar envelopes, and portion math across your guest list.
                </p>
                <a href="{{ route('food-calculator') }}" class="btn btn-outline" style="width: 100%; border: 1px solid var(--primary); font-size: 13px;">
                    Open Calculator
                </a>
            </div>

            <!-- Browse Event Showcases -->
            <div class="glass-card" style="padding: 22px;">
                <div style="font-size: 24px; color: var(--primary); margin-bottom: 10px;">
                    <i class="fas fa-compass"></i>
                </div>
                <h4 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 6px;">
                    Curated Event Categories
                </h4>
                <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 14px;">
                    Explore weddings, nightclub DJ rigs, five-star hotel venues, and reunion packages.
                </p>
                <a href="{{ route('events.index') }}" class="btn btn-outline" style="width: 100%; border: 1px solid #cbd5e1; font-size: 13px;">
                    Explore Categories
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
