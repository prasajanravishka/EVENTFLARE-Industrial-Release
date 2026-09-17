@extends('layouts.admin', ['activePage' => 'dashboard', 'title' => 'Executive Overview - EVENTFLARE Admin Console'])

@section('content')
<!-- Executive Welcome & Quick Action Bar -->
<div class="dashboard-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <div class="dashboard-title">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
            <h1 style="font-size: 26px; font-weight: 900; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-chart-line" style="color: var(--primary);"></i> Executive Command Center
            </h1>
            <span style="display: inline-flex; align-items: center; gap: 6px; background: #ecfdf5; color: #059669; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 20px; border: 1px solid #a7f3d0;">
                <span style="width: 7px; height: 7px; border-radius: 50%; background: #10b981; box-shadow: 0 0 0 2px rgba(16,185,129,0.3);"></span> Live Operations
            </span>
        </div>
        <p style="color: var(--text-muted); font-size: 13px; margin: 0;">
            Platform pulse, customer reservations, and accredited vendor ecosystem across Sri Lanka.
        </p>
    </div>

    <!-- Quick Navigation Shortcuts -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline" style="border-radius: 20px; padding: 7px 14px; font-size: 12px; font-weight: 700; background: #ffffff; border: 1px solid #e2e8f0; color: var(--text-heading); display: inline-flex; align-items: center; gap: 6px; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <i class="fas fa-receipt" style="color: var(--primary);"></i> Reservations
        </a>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline" style="border-radius: 20px; padding: 7px 14px; font-size: 12px; font-weight: 700; background: #ffffff; border: 1px solid #e2e8f0; color: var(--text-heading); display: inline-flex; align-items: center; gap: 6px; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <i class="fas fa-store" style="color: #3b82f6;"></i> Vendors
        </a>
        <a href="{{ route('admin.event-types.index') }}" class="btn btn-outline" style="border-radius: 20px; padding: 7px 14px; font-size: 12px; font-weight: 700; background: #ffffff; border: 1px solid #e2e8f0; color: var(--text-heading); display: inline-flex; align-items: center; gap: 6px; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <i class="fas fa-layer-group" style="color: #10b981;"></i> Catalog
        </a>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline" style="border-radius: 20px; padding: 7px 14px; font-size: 12px; font-weight: 700; background: #ffffff; border: 1px solid #e2e8f0; color: var(--text-heading); display: inline-flex; align-items: center; gap: 6px; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <i class="fas fa-envelope" style="color: #f59e0b;"></i> Inquiries
            @if(($stats['unread_messages'] ?? 0) > 0)
                <span style="background: #ef4444; color: #fff; font-size: 10px; padding: 1px 6px; border-radius: 10px;">{{ $stats['unread_messages'] }}</span>
            @endif
        </a>
    </div>
</div>

<!-- ========================================== -->
<!-- URGENT OPERATIONAL ACTION QUEUE BANNER     -->
<!-- ========================================== -->
@php
    $hasPendingAction = ($stats['pending_bookings'] > 0 || $stats['unread_messages'] > 0 || ($stats['shortage_count'] ?? 0) > 0);
@endphp

@if($hasPendingAction)
    <div class="glass-card" style="padding: 16px 20px; margin-bottom: 24px; border-left: 4px solid #f59e0b; background: linear-gradient(135deg, rgba(254, 243, 199, 0.4) 0%, rgba(255, 255, 255, 0.8) 100%); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fas fa-bell"></i>
            </div>
            <div>
                <strong style="color: #92400e; font-size: 14px; display: block;">Operational Action Required</strong>
                <span style="font-size: 12px; color: #78350f;">
                    You have tasks pending your executive review:
                    @if($stats['pending_bookings'] > 0)
                        <strong>{{ $stats['pending_bookings'] }}</strong> pending {{ Str::plural('reservation', $stats['pending_bookings']) }}
                    @endif
                    @if($stats['unread_messages'] > 0)
                        · <strong>{{ $stats['unread_messages'] }}</strong> unread {{ Str::plural('inquiry', $stats['unread_messages']) }}
                    @endif
                    @if(($stats['shortage_count'] ?? 0) > 0)
                        · <strong>{{ $stats['shortage_count'] }}</strong> catalog supply {{ Str::plural('deficit', $stats['shortage_count']) }}
                    @endif
                </span>
            </div>
        </div>

        <div style="display: flex; gap: 8px;">
            @if($stats['pending_bookings'] > 0)
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="btn btn-primary" style="padding: 6px 14px; font-size: 11px; border-radius: 20px; font-weight: 700; text-decoration: none;">
                    Review Reservations
                </a>
            @endif
            @if($stats['unread_messages'] > 0)
                <a href="{{ route('admin.messages.index', ['filter' => 'unread']) }}" class="btn btn-outline" style="padding: 6px 14px; font-size: 11px; border-radius: 20px; font-weight: 700; text-decoration: none; border-color: #cbd5e1;">
                    Answer Messages
                </a>
            @endif
            @if(($stats['shortage_count'] ?? 0) > 0)
                <a href="{{ route('admin.event-types.index') }}" class="btn btn-outline" style="padding: 6px 14px; font-size: 11px; border-radius: 20px; font-weight: 700; text-decoration: none; border-color: #fde68a; background: #fffbeb; color: #b45309;">
                    Accredit Vendors
                </a>
            @endif
        </div>
    </div>
@endif

<!-- ========================================== -->
<!-- MULTI-METRIC EXECUTIVE KPI GRID            -->
<!-- ========================================== -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 24px;">
    <!-- 1. Total Reservations -->
    <div class="glass-card" style="padding: 20px; display: flex; align-items: flex-start; justify-content: space-between;">
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Reservations Pipeline</span>
            <div style="font-size: 26px; font-weight: 900; color: var(--text-heading); margin: 4px 0 2px 0;">
                {{ number_format($stats['bookings']) }}
            </div>
            <div style="display: flex; gap: 8px; font-size: 11px; font-weight: 700;">
                <span style="color: #16a34a;"><i class="fas fa-check-circle fa-xs"></i> {{ $statusCounts['completed'] ?? 0 }} Done</span>
                <span style="color: #d97706;"><i class="fas fa-clock fa-xs"></i> {{ $stats['pending_bookings'] }} Pending</span>
            </div>
        </div>
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(139, 92, 246, 0.12); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fas fa-calendar-check"></i>
        </div>
    </div>

    <!-- 2. Gross Catering / Reservation Volume -->
    <div class="glass-card" style="padding: 20px; display: flex; align-items: flex-start; justify-content: space-between;">
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Gross Managed Volume</span>
            <div style="font-size: 24px; font-weight: 900; color: var(--text-heading); margin: 4px 0 2px 0;">
                LKR {{ number_format($stats['budget'], 0) }}
            </div>
            <div style="display: flex; gap: 8px; font-size: 11px; color: var(--text-muted);">
                <span>Food: <strong>LKR {{ number_format($stats['food_budget'] ?? 0, 0) }}</strong></span>
            </div>
        </div>
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fas fa-money-bill-wave"></i>
        </div>
    </div>

    <!-- 3. Marketplace Network -->
    <div class="glass-card" style="padding: 20px; display: flex; align-items: flex-start; justify-content: space-between;">
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Marketplace Network</span>
            <div style="font-size: 26px; font-weight: 900; color: var(--text-heading); margin: 4px 0 2px 0;">
                {{ number_format($stats['users']) }}
            </div>
            <div style="font-size: 11px; color: var(--text-muted);">
                <strong style="color: var(--primary);">{{ $stats['buyers'] }}</strong> Clients · <strong style="color: #3b82f6;">{{ $stats['suppliers'] }}</strong> Vendors
            </div>
        </div>
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(59, 130, 246, 0.12); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fas fa-users"></i>
        </div>
    </div>

    <!-- 4. Catalog & Supply Health -->
    <div class="glass-card" style="padding: 20px; display: flex; align-items: flex-start; justify-content: space-between;">
        <div>
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Catalog Health</span>
            <div style="font-size: 26px; font-weight: 900; color: var(--text-heading); margin: 4px 0 2px 0;">
                {{ $stats['active_event_types'] }} <small style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Sectors</small>
            </div>
            <div style="font-size: 11px;">
                @if(($stats['shortage_count'] ?? 0) > 0)
                    <span style="color: #d97706; font-weight: 700;"><i class="fas fa-triangle-exclamation fa-xs"></i> {{ $stats['shortage_count'] }} Supply Deficits</span>
                @else
                    <span style="color: #16a34a; font-weight: 700;"><i class="fas fa-shield-check fa-xs"></i> 100% Vendor Coverage</span>
                @endif
            </div>
        </div>
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.12); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fas fa-cubes"></i>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- TWIN VISUAL ANALYTICS (CHART.JS GRIDS)     -->
<!-- ========================================== -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 30px;">
    <!-- Chart 1: Monthly Booking Velocity -->
    <div class="glass-card" style="padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <div>
                <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-chart-area" style="color: var(--primary);"></i> Monthly Booking Velocity ({{ date('Y') }})
                </h3>
                <small style="color: var(--text-muted); font-size: 12px;">Reservation intake across the current calendar year</small>
            </div>
            <span style="font-size: 11px; font-weight: 700; color: var(--primary); background: #ede9fe; padding: 3px 10px; border-radius: 12px;">
                Annual Velocity
            </span>
        </div>

        <div style="height: 240px; position: relative;">
            <canvas id="monthlyBookingsChart"></canvas>
        </div>
    </div>

    <!-- Chart 2: Booking Status Mix Donut -->
    <div class="glass-card" style="padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <div>
                <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-chart-pie" style="color: #3b82f6;"></i> Status Distribution
                </h3>
                <small style="color: var(--text-muted); font-size: 12px;">Reservation fulfillment mix</small>
            </div>
        </div>

        <div style="height: 200px; position: relative;">
            <canvas id="statusDonutChart"></canvas>
        </div>

        <!-- Mini Status Breakdown Legend -->
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 14px; font-size: 11px;">
            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b;"></span>
                <span style="color: #64748b;">Pending ({{ $statusCounts['pending'] ?? 0 }})</span>
            </div>
            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #3b82f6;"></span>
                <span style="color: #64748b;">Confirmed ({{ $statusCounts['confirmed'] ?? 0 }})</span>
            </div>
            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #8b5cf6;"></span>
                <span style="color: #64748b;">In Progress ({{ $statusCounts['in_progress'] ?? 0 }})</span>
            </div>
            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
                <span style="color: #64748b;">Completed ({{ $statusCounts['completed'] ?? 0 }})</span>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- TWO-COLUMN OPERATIONAL SPLIT LAYOUT        -->
<!-- ========================================== -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
    <!-- Left: Latest Event Bookings Ledger -->
    <div class="glass-card" style="padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <div>
                <h3 style="font-size: 17px; font-weight: 800; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-receipt" style="color: var(--primary);"></i> Recent Event Reservations
                </h3>
                <small style="color: var(--text-muted); font-size: 12px;">Active customer bookings in the pipeline</small>
            </div>
            <a href="{{ route('admin.bookings.index') }}" style="font-size: 12px; font-weight: 800; color: var(--primary); text-decoration: none;">
                View All Ledger &rarr;
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                <thead>
                    <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">Client</th>
                        <th style="padding: 10px;">Category</th>
                        <th style="padding: 10px;">Date & Venue</th>
                        <th style="padding: 10px;">Status</th>
                        <th style="padding: 10px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $rb)
                        @php
                            $status = strtolower($rb->status);
                            $badgeBg = '#f1f5f9';
                            $badgeColor = '#475569';
                            if ($status === 'pending') {
                                $badgeBg = '#fffbeb'; $badgeColor = '#b45309';
                            } elseif ($status === 'confirmed') {
                                $badgeBg = '#eff6ff'; $badgeColor = '#1d4ed8';
                            } elseif (in_array($status, ['in progress', 'in_progress'])) {
                                $badgeBg = '#f5f3ff'; $badgeColor = '#6d28d9';
                            } elseif ($status === 'completed') {
                                $badgeBg = '#f0fdf4'; $badgeColor = '#15803d';
                            } elseif ($status === 'cancelled') {
                                $badgeBg = '#fef2f2'; $badgeColor = '#dc2626';
                            }
                        @endphp
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 10px; font-weight: 800; font-family: monospace;">
                                <a href="{{ route('admin.bookings.show', $rb->BookingID) }}" style="text-decoration: none; color: var(--primary); display: inline-flex; align-items: center; gap: 4px;" title="View Booking Lifecycle Dossier">
                                    <i class="fas fa-receipt fa-xs"></i>#{{ $rb->BookingID }}
                                </a>
                            </td>
                            <td style="padding: 12px 10px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; flex-shrink: 0;">
                                        {{ strtoupper(substr($rb->user->fullname ?? $rb->user_name ?? 'C', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--text-heading);">{{ $rb->user->fullname ?? $rb->user_name }}</div>
                                        <small style="color: #94a3b8; font-size: 11px;">{{ $rb->user->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 12px 10px;">
                                <span style="font-size: 11px; font-weight: 700; background: #f8fafc; border: 1px solid #e2e8f0; padding: 2px 8px; border-radius: 10px; color: var(--text-heading);">
                                    {{ $rb->EventType }}
                                </span>
                            </td>
                            <td style="padding: 12px 10px; color: #475569; font-size: 12px;">
                                <div><i class="fas fa-calendar-day fa-xs" style="color: var(--primary); margin-right: 4px;"></i>{{ \Carbon\Carbon::parse($rb->EventDate)->format('M d, Y') }}</div>
                                <small style="color: #94a3b8;"><i class="fas fa-map-marker-alt fa-xs" style="color: #ef4444; margin-right: 3px;"></i>{{ Str::limit($rb->Place, 18) }}</small>
                            </td>
                            <td style="padding: 12px 10px;">
                                <span style="font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 10px; text-transform: capitalize; background: {{ $badgeBg }}; color: {{ $badgeColor }};">
                                    {{ str_replace('_', ' ', $rb->status) }}
                                </span>
                            </td>
                            <td style="padding: 12px 10px; text-align: right;">
                                <a href="{{ route('admin.bookings.show', $rb->BookingID) }}" class="btn btn-outline" style="border: 1px solid #c7d2fe; color: #4338ca; padding: 3px 8px; font-size: 11px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;">
                                    <i class="fas fa-eye"></i> Dossier
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">No event reservations recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right: Category Popularity & Recent Customer Feedback -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Category Popularity Share -->
        <div class="glass-card" style="padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-ranking-star" style="color: #f59e0b;"></i> Category Demand
                </h3>
                <small style="color: var(--text-muted); font-size: 11px;">Booking share</small>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                @forelse($categoryPopularity as $cp)
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px;">
                            <span style="font-weight: 700; color: var(--text-heading);">{{ $cp->EventType }}</span>
                            <span style="font-weight: 800; color: var(--primary);">{{ $cp->total }} ({{ $cp->percentage }}%)</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, var(--primary), #a78bfa); border-radius: 4px; width: {{ $cp->percentage }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p style="font-size: 12px; color: var(--text-muted); margin: 0;">No bookings categorized yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Customer Endorsements Stream -->
        <div class="glass-card" style="padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                <h3 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin: 0; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-star" style="color: #eab308;"></i> Recent Endorsements
                </h3>
                <a href="{{ route('admin.ratings.index') }}" style="font-size: 11px; font-weight: 800; color: var(--primary); text-decoration: none;">
                    Moderate &rarr;
                </a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                @forelse($recentRatings as $rr)
                    <div style="background: #f8fafc; padding: 10px 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <strong style="color: var(--text-heading); font-size: 12px;">{{ $rr->user->fullname ?? $rr->user->username ?? 'Customer' }}</strong>
                            <div style="color: #f59e0b; font-size: 10px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $rr->rating ? '' : 'fa-star-o' }}" style="color: {{ $i <= $rr->rating ? '#f59e0b' : '#cbd5e1' }};"></i>
                                @endfor
                            </div>
                        </div>
                        <p style="color: #64748b; font-size: 11px; margin: 0 0 4px 0; line-height: 1.3;">
                            "{{ Str::limit($rr->comment, 65) }}"
                        </p>
                        <small style="color: var(--text-muted); font-size: 10px;">
                            Vendor: <strong>{{ $rr->supplier->business_name ?? 'Accredited Supplier' }}</strong>
                        </small>
                    </div>
                @empty
                    <p style="font-size: 12px; color: var(--text-muted); margin: 0;">No reviews submitted yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Monthly Bookings Area Chart
        const velocityCtx = document.getElementById('monthlyBookingsChart');
        if (velocityCtx) {
            const chartLabels = {!! json_encode($chartLabels) !!};
            const chartData = {!! json_encode($chartData) !!};

            const ctx = velocityCtx.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 220);
            gradient.addColorStop(0, 'rgba(139, 92, 246, 0.45)');
            gradient.addColorStop(1, 'rgba(139, 92, 246, 0.02)');

            new Chart(velocityCtx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Reservations',
                        data: chartData,
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: '#8b5cf6',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Bookings';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 }, color: '#64748b' }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                stepSize: 1,
                                font: { size: 11 },
                                color: '#64748b'
                            }
                        }
                    }
                }
            });
        }

        // 2. Booking Status Donut Chart
        const statusCtx = document.getElementById('statusDonutChart');
        if (statusCtx) {
            const statusCounts = {!! json_encode($statusCounts) !!};

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Confirmed', 'In Progress', 'Completed', 'Cancelled'],
                    datasets: [{
                        data: [
                            statusCounts.pending || 0,
                            statusCounts.confirmed || 0,
                            statusCounts.in_progress || 0,
                            statusCounts.completed || 0,
                            statusCounts.cancelled || 0
                        ],
                        backgroundColor: [
                            '#f59e0b', // Pending
                            '#3b82f6', // Confirmed
                            '#8b5cf6', // In Progress
                            '#10b981', // Completed
                            '#ef4444'  // Cancelled
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.parsed;
                                    const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                    return ` ${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush

