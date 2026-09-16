@extends('layouts.admin', ['activePage' => 'bookings', 'title' => 'Manage Bookings - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <h1>Event Reservations Ledger</h1>
        <p>Comprehensive oversight of client bookings, stage schedules, and vendor assignments.</p>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="glass-card" style="padding: 20px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.bookings.index') }}" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: center;">
        <div style="flex: 1; min-width: 220px;">
            <input type="text" name="search" class="form-input" placeholder="Search by Booking ID, client, or venue..." value="{{ $search }}">
        </div>

        <div>
            <select name="status" class="form-input" style="padding: 10px 14px;">
                <option value="">All Statuses</option>
                <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $statusFilter === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="in progress" {{ $statusFilter === 'in progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ $statusFilter === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $statusFilter === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div>
            <select name="type" class="form-input" style="padding: 10px 14px;">
                <option value="">All Categories</option>
                @foreach($eventTypes as $et)
                    <option value="{{ $et->type_name }}" {{ $typeFilter === $et->type_name ? 'selected' : '' }}>{{ $et->type_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 20px; font-weight: 700;">
            <i class="fas fa-filter"></i> Filter
        </button>

        @if($search || $statusFilter || $typeFilter)
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary" style="padding: 10px 16px; border-radius: 20px;">
                Clear
            </a>
        @endif
    </form>
</div>

<!-- Bookings Ledger Table -->
<div class="glass-card" style="padding: 24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
        <thead>
            <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px;">Booking ID</th>
                <th style="padding: 12px 14px;">Client</th>
                <th style="padding: 12px 14px;">Category</th>
                <th style="padding: 12px 14px;">Date & Session</th>
                <th style="padding: 12px 14px;">Venue</th>
                <th style="padding: 12px 14px;">Guests</th>
                <th style="padding: 12px 14px;">Assigned Vendors</th>
                <th style="padding: 12px 14px;">Status</th>
                <th style="padding: 12px 14px; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $b)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 14px;">
                        <strong style="color: var(--primary); font-family: monospace;">#{{ $b->BookingID }}</strong>
                    </td>
                    <td style="padding: 14px;">
                        <div style="font-weight: 700; color: var(--text-heading);">{{ $b->user->fullname ?? $b->user_name }}</div>
                        <small style="color: #64748b;">{{ $b->user->email ?? '' }}</small>
                    </td>
                    <td style="padding: 14px; font-weight: 600;">{{ $b->EventType }}</td>
                    <td style="padding: 14px; color: #475569;">
                        {{ \Carbon\Carbon::parse($b->EventDate)->format('M d, Y') }}
                        <small style="display: block; color: #94a3b8;">{{ $b->DayNight }}</small>
                    </td>
                    <td style="padding: 14px; color: #64748b;">
                        <i class="fas fa-map-marker-alt fa-xs" style="color: #ef4444;"></i> {{ $b->Place }}
                    </td>
                    <td style="padding: 14px; font-weight: 700;">{{ $b->NumberOfGuests }}</td>
                    <td style="padding: 14px;">
                        <span style="font-size: 11px; font-weight: 700; background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 10px;">
                            {{ $b->services->count() }} Assigned
                        </span>
                    </td>
                    <td style="padding: 14px;">
                        <form method="POST" action="{{ route('admin.bookings.status', $b->BookingID) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" style="font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 10px; border: 1px solid #cbd5e1; cursor: pointer;">
                                <option value="pending" {{ $b->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="in progress" {{ $b->status === 'in progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $b->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $b->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td style="padding: 14px; text-align: right; white-space: nowrap;">
                        <form method="POST" action="{{ route('admin.bookings.destroy', $b->BookingID) }}" style="display: inline;" onsubmit="return confirm('Permanently delete booking #{{ $b->BookingID }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="border: 1px solid #fee2e2; color: #ef4444; padding: 4px 10px; font-size: 11px; border-radius: 12px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: var(--text-muted); padding: 40px;">No reservations found matching the selected filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
