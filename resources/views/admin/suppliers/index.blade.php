@extends('layouts.admin', ['activePage' => 'suppliers', 'title' => 'Supplier Directory - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <h1>Supplier & Vendor Directory</h1>
        <p>Oversee accredited event vendors, regional coverage, packages, and registered credentials.</p>
    </div>
</div>

<!-- Search & Add Supplier Bar -->
<div class="glass-card" style="padding: 20px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.suppliers.index') }}" style="display: flex; gap: 14px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <input type="text" name="search" class="form-input" placeholder="Search by business name, category, or city..." value="{{ $search }}">
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 20px; font-weight: 700;">
            <i class="fas fa-search"></i> Search Vendors
        </button>
        @if($search)
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary" style="padding: 10px 16px; border-radius: 20px;">Clear</a>
        @endif
    </form>
</div>

<!-- Suppliers Table -->
<div class="glass-card" style="padding: 24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
        <thead>
            <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px;">Business Name</th>
                <th style="padding: 12px 14px;">Speciality</th>
                <th style="padding: 12px 14px;">Location</th>
                <th style="padding: 12px 14px;">Phone</th>
                <th style="padding: 12px 14px;">Accredited Services</th>
                <th style="padding: 12px 14px;">Active Packages</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $s)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 14px;">
                        <div style="font-weight: 800; color: var(--text-heading);">{{ $s->business_name }}</div>
                        <small style="color: #64748b;">@<span>{{ $s->user->username ?? 'vendor' }}</span> ({{ $s->user->email ?? '' }})</small>
                    </td>
                    <td style="padding: 14px; font-weight: 600; color: var(--primary);">
                        {{ $s->category }}
                    </td>
                    <td style="padding: 14px; color: #64748b;">
                        <i class="fas fa-map-marker-alt fa-xs" style="color: #ef4444;"></i> {{ $s->location }}
                    </td>
                    <td style="padding: 14px; font-weight: 600;">
                        {{ $s->contact_phone }}
                    </td>
                    <td style="padding: 14px;">
                        <span style="font-size: 11px; font-weight: 700; background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 10px;">
                            {{ $s->services->count() }} Services
                        </span>
                    </td>
                    <td style="padding: 14px;">
                        <span style="font-size: 11px; font-weight: 700; background: #fdf2f8; color: #be185d; padding: 2px 8px; border-radius: 10px;">
                            {{ $s->listings->count() }} Packages
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">No suppliers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection
