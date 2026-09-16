@extends('layouts.eventflare')

@section('title', ($supplier->business_name ?? 'Supplier Portal') . ' — EVENTFLARE')

@section('content')
<div style="max-width: 1200px; margin: 40px auto 80px; padding: 0 24px;">

    <!-- Supplier Banner -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                <i class="fas fa-store"></i> Supplier Command Center
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: var(--text-heading); margin-bottom: 6px;">
                {{ $supplier->business_name ?? 'Vendor Portal' }}
            </h1>
            <p style="color: var(--text-muted); font-size: 15px;">
                {{ $supplier->category ?? 'Event Specialist' }} &bull; <i class="fas fa-map-marker-alt fa-xs" style="color:#ef4444;"></i> {{ $supplier->location ?? 'Sri Lanka' }}
            </p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('supplier.listings.index') }}" class="btn btn-primary" style="padding: 12px 24px; border-radius: 30px; font-weight: 700;">
                <i class="fas fa-tags"></i> Manage Packages
            </a>
            <a href="{{ route('supplier.profile.edit') }}" class="btn btn-secondary" style="padding: 12px 24px; border-radius: 30px; font-weight: 700;">
                <i class="fas fa-sliders-h"></i> Business Profile
            </a>
        </div>
    </div>

    <!-- Live Metric Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 35px;">
        <!-- Metric 1: Active Listings -->
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 18px;">
            <div style="width: 54px; height: 54px; border-radius: 14px; background: rgba(139, 92, 246, 0.15); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-boxes"></i>
            </div>
            <div>
                <div style="font-size: 28px; font-weight: 900; color: var(--text-heading); line-height: 1;">{{ $listingCount }}</div>
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600; margin-top: 4px;">Public Listings</div>
            </div>
        </div>

        <!-- Metric 2: Average Rating Score -->
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 18px;">
            <div style="width: 54px; height: 54px; border-radius: 14px; background: rgba(245, 158, 11, 0.15); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-star"></i>
            </div>
            <div>
                <div style="font-size: 28px; font-weight: 900; color: var(--text-heading); line-height: 1;">
                    {{ $ratingCount > 0 ? number_format($ratingAvg, 1) : '—' }}
                </div>
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600; margin-top: 4px;">
                    Average Score ({{ $ratingCount }} reviews)
                </div>
            </div>
        </div>

        <!-- Metric 3: Assigned Bookings -->
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 18px;">
            <div style="width: 54px; height: 54px; border-radius: 14px; background: rgba(59, 130, 246, 0.15); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-handshake"></i>
            </div>
            <div>
                <div style="font-size: 28px; font-weight: 900; color: var(--text-heading); line-height: 1;">{{ $assignedBookingsCount }}</div>
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600; margin-top: 4px;">Assigned Client Bookings</div>
            </div>
        </div>

        <!-- Metric 4: Platform Status -->
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 18px;">
            <div style="width: 54px; height: 54px; border-radius: 14px; background: rgba(16, 185, 129, 0.15); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-certificate"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 900; color: #10b981; line-height: 1;">Accredited</div>
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600; margin-top: 4px;">Verified Vendor Tier</div>
            </div>
        </div>
    </div>

    <!-- Verified Customer Reviews Section -->
    <div class="glass-card" style="padding: 28px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <h3 style="font-size: 18px; font-weight: 800; color: var(--text-heading); margin: 0;">
                <i class="fas fa-comments" style="color: #f59e0b; margin-right: 8px;"></i> Verified Client Reviews & Ratings
            </h3>
            <span style="font-size: 13px; color: var(--text-muted);">{{ $ratingCount }} Total Endorsements</span>
        </div>

        @if($reviews->isEmpty())
            <div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                <i class="fas fa-star-half-alt" style="font-size: 36px; opacity: 0.3; margin-bottom: 12px; display: block; color: #f59e0b;"></i>
                <p style="margin: 0; font-size: 14px;">No customer ratings on record yet. Complete your assigned bookings to build verified reviews.</p>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 18px;">
                @foreach($reviews as $rev)
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <div style="color: #f59e0b; font-size: 14px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $rev->rating ? '' : '-o' }}"></i>
                                @endfor
                                <strong style="color: #b45309; font-size: 13px; margin-left: 4px;">{{ $rev->rating }}.0</strong>
                            </div>
                            <small style="color: #94a3b8; font-size: 11px;">{{ $rev->created_at->format('M d, Y') }}</small>
                        </div>
                        @if($rev->review_title)
                            <h4 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin: 0 0 6px;">{{ $rev->review_title }}</h4>
                        @endif
                        <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin: 0 0 10px;">{{ $rev->review_text }}</p>
                        <div style="font-size: 12px; color: var(--text-muted); border-top: 1px dashed #cbd5e1; padding-top: 8px;">
                            <i class="fas fa-user-check fa-xs" style="color: #10b981;"></i> {{ $rev->user->fullname ?? $rev->user->username }}
                            @if($rev->booking)
                                &bull; <em>{{ $rev->booking->EventType }}</em>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
