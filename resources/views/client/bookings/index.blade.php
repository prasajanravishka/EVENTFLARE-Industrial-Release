@extends('layouts.eventflare')

@section('title', 'My Reservations & Bookings — EVENTFLARE')

@section('content')
<div style="max-width: 1200px; margin: 40px auto 80px; padding: 0 24px;">

    <!-- List Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                <i class="fas fa-list-alt"></i> Booking Ledger
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: var(--text-heading); margin-bottom: 4px;">
                My Reservations & Bookings
            </h1>
            <p style="color: var(--text-muted); font-size: 14px;">Track lifecycle milestones, supplier confirmations, and download your verified itineraries.</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="border-radius: 30px; padding: 10px 20px; font-size: 13px;">
                <i class="fas fa-arrow-left"></i> Dashboard Hub
            </a>
            <a href="{{ route('events.index') }}" class="btn btn-primary" style="border-radius: 30px; padding: 10px 20px; font-size: 13px;">
                <i class="fas fa-plus"></i> New Reservation
            </a>
        </div>
    </div>

    <!-- Bookings Table Container -->
    <div class="glass-card" style="padding: 24px; overflow-x: auto;">
        @if($bookings->isEmpty())
            <div style="text-align: center; padding: 60px 20px; color: var(--text-muted);">
                <i class="fas fa-calendar-times" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px; display: block;"></i>
                <h3 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-bottom: 8px;">No Bookings on Record</h3>
                <p style="margin-bottom: 20px; font-size: 14px;">You haven't initiated any event reservations with your account yet.</p>
                <a href="{{ route('events.index') }}" class="btn btn-primary" style="padding: 10px 24px; border-radius: 25px;">
                    Reserve Your First Celebration
                </a>
            </div>
        @else
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 2px solid #e2e8f0; color: var(--text-muted); font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th style="padding: 14px 16px;">Booking ID</th>
                        <th style="padding: 14px 16px;">Event Type</th>
                        <th style="padding: 14px 16px;">Venue / City</th>
                        <th style="padding: 14px 16px;">Guests</th>
                        <th style="padding: 14px 16px;">Date & Session</th>
                        <th style="padding: 14px 16px;">Catering Tier</th>
                        <th style="padding: 14px 16px;">Status</th>
                        <th style="padding: 14px 16px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $b)
                        @php
                            $st = $b->status ?: 'pending';
                            $badges = [
                                'pending' => ['bg' => '#fef3c7', 'color' => '#b45309'],
                                'confirmed' => ['bg' => '#dcfce7', 'color' => '#15803d'],
                                'in progress' => ['bg' => '#dbeafe', 'color' => '#1d4ed8'],
                                'completed' => ['bg' => '#dcfce7', 'color' => '#15803d'],
                                'cancelled' => ['bg' => '#fee2e2', 'color' => '#b91c1c'],
                            ];
                            $badge = $badges[$st] ?? ['bg' => '#f1f5f9', 'color' => '#475569'];
                        @endphp
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 16px;">
                                <strong style="color: var(--primary); font-family: monospace; font-size: 14px;">#{{ $b->BookingID }}</strong>
                            </td>
                            <td style="padding: 16px; font-weight: 700; color: var(--text-heading);">
                                {{ $b->EventType }}
                            </td>
                            <td style="padding: 16px; color: #64748b;">
                                <i class="fas fa-map-marker-alt fa-xs" style="color: #ef4444; margin-right: 4px;"></i> {{ $b->Place }}
                            </td>
                            <td style="padding: 16px; font-weight: 700;">
                                {{ $b->NumberOfGuests }}
                            </td>
                            <td style="padding: 16px; color: #475569;">
                                {{ \Carbon\Carbon::parse($b->EventDate)->format('M d, Y') }}
                                <small style="display: block; font-size: 11px; color: #94a3b8;">{{ $b->DayNight }} Event</small>
                            </td>
                            <td style="padding: 16px; color: #64748b;">
                                {{ $b->FoodPreferences ?: 'Standard' }}
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 12px; text-transform: capitalize;">
                                    {{ $st }}
                                </span>
                            </td>
                            <td style="padding: 16px; text-align: right; white-space: nowrap;">
                                <a href="{{ route('client.bookings.show', $b->BookingID) }}" class="btn btn-outline" style="padding: 6px 14px; font-size: 12px; border-radius: 20px; border: 1px solid var(--primary); color: var(--primary); margin-right: 6px;">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                                <a href="{{ route('client.bookings.pdf', $b->BookingID) }}" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; border-radius: 20px;">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
