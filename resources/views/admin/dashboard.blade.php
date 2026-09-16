@extends('layouts.admin', ['activePage' => 'dashboard', 'title' => 'Overview - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <h1>Executive Overview</h1>
        <p>Real-time platform activity, client reservations, and vendor operations across Sri Lanka.</p>
    </div>
    <div class="dashboard-user">
        <i class="fas fa-user-shield"></i>
        <span>{{ Auth::user()->username }} (Admin)</span>
    </div>
</div>

<!-- Stat Cards Grid -->
<div class="stat-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card glass-card" style="padding: 22px; display: flex; align-items: center; gap: 16px;">
        <div class="stat-icon icon-blue" style="width: 50px; height: 50px; border-radius: 12px; background: rgba(59, 130, 246, 0.15); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ $stats['users'] }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Total Users ({{ $stats['buyers'] }} Clients, {{ $stats['suppliers'] }} Vendors)</p>
        </div>
    </div>

    <div class="stat-card glass-card" style="padding: 22px; display: flex; align-items: center; gap: 16px;">
        <div class="stat-icon icon-purple" style="width: 50px; height: 50px; border-radius: 12px; background: rgba(139, 92, 246, 0.15); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ $stats['bookings'] }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Bookings ({{ $stats['pending_bookings'] }} Action Required)</p>
        </div>
    </div>

    <div class="stat-card glass-card" style="padding: 22px; display: flex; align-items: center; gap: 16px;">
        <div class="stat-icon icon-green" style="width: 50px; height: 50px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fas fa-layer-group"></i>
        </div>
        <div class="stat-info">
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ $stats['active_event_types'] }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Active Event Categories</p>
        </div>
    </div>

    <div class="stat-card glass-card" style="padding: 22px; display: flex; align-items: center; gap: 16px;">
        <div class="stat-icon icon-amber" style="width: 50px; height: 50px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <h3 style="font-size: 24px; font-weight: 900; margin: 0; color: var(--text-heading);">{{ $stats['unread_messages'] }}</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 0;">Unread Customer Inquiries</p>
        </div>
    </div>
</div>

<!-- Two-Column Operational Layout -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start; margin-bottom: 30px;">
    <!-- Recent Bookings Table -->
    <div class="glass-card" style="padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <h3 style="font-size: 17px; font-weight: 800; color: var(--text-heading); margin: 0;">
                <i class="fas fa-history" style="color: var(--primary); margin-right: 6px;"></i> Latest Event Bookings
            </h3>
            <a href="{{ route('admin.bookings.index') }}" style="font-size: 13px; font-weight: 700; color: var(--primary);">View All &rarr;</a>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                <thead>
                    <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 8px 10px;">ID</th>
                        <th style="padding: 8px 10px;">Client</th>
                        <th style="padding: 8px 10px;">Type</th>
                        <th style="padding: 8px 10px;">Date</th>
                        <th style="padding: 8px 10px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $rb)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px; font-weight: 800; font-family: monospace; color: var(--primary);">#{{ $rb->BookingID }}</td>
                            <td style="padding: 10px; font-weight: 600;">{{ $rb->user_name }}</td>
                            <td style="padding: 10px;">{{ $rb->EventType }}</td>
                            <td style="padding: 10px; color: #64748b;">{{ \Carbon\Carbon::parse($rb->EventDate)->format('M d, Y') }}</td>
                            <td style="padding: 10px;">
                                <span style="font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 10px; text-transform: capitalize; background: #dcfce7; color: #15803d;">
                                    {{ $rb->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">No bookings recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Booking Lifecycle Distribution -->
    <div class="glass-card" style="padding: 24px;">
        <h3 style="font-size: 17px; font-weight: 800; color: var(--text-heading); margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <i class="fas fa-chart-pie" style="color: var(--primary); margin-right: 6px;"></i> Booking Status Mix
        </h3>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($statusCounts as $st => $cnt)
                <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <span style="font-size: 13px; font-weight: 700; text-transform: capitalize; color: var(--text-heading);">{{ str_replace('_', ' ', $st) }}</span>
                    <span style="font-size: 14px; font-weight: 900; color: var(--primary);">{{ $cnt }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
