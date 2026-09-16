@extends('layouts.admin', ['activePage' => 'ratings', 'title' => 'Ratings & Reviews - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <h1>Ratings & Customer Endorsements</h1>
        <p>Moderation console for customer feedback, verified supplier ratings, and public review status.</p>
    </div>
</div>

<!-- Moderation Filter Tabs -->
<div class="glass-card" style="padding: 16px; margin-bottom: 24px; display: flex; gap: 10px; flex-wrap: wrap;">
    <a href="{{ route('admin.ratings.index', ['status' => 'all']) }}" class="btn {{ $status === 'all' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 8px 18px; border-radius: 20px; font-size: 13px;">
        All Reviews
    </a>
    <a href="{{ route('admin.ratings.index', ['status' => 'approved']) }}" class="btn {{ $status === 'approved' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 8px 18px; border-radius: 20px; font-size: 13px;">
        Published (Approved)
    </a>
    <a href="{{ route('admin.ratings.index', ['status' => 'hidden']) }}" class="btn {{ $status === 'hidden' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 8px 18px; border-radius: 20px; font-size: 13px;">
        Hidden Reviews
    </a>
</div>

<!-- Ratings Table -->
<div class="glass-card" style="padding: 24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
        <thead>
            <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px;">Customer</th>
                <th style="padding: 12px 14px;">Supplier Reviewed</th>
                <th style="padding: 12px 14px;">Score</th>
                <th style="padding: 12px 14px;">Review Content</th>
                <th style="padding: 12px 14px;">Booking Ref</th>
                <th style="padding: 12px 14px;">Moderation</th>
                <th style="padding: 12px 14px; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ratings as $r)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 14px;">
                        <strong style="color: var(--text-heading);">{{ $r->user->fullname ?? $r->user->username }}</strong>
                    </td>
                    <td style="padding: 14px; font-weight: 700; color: var(--primary);">
                        {{ $r->supplier->business_name ?? 'Vendor' }}
                    </td>
                    <td style="padding: 14px;">
                        <span style="color: #f59e0b; font-weight: 800;">
                            <i class="fas fa-star"></i> {{ $r->rating }}.0
                        </span>
                    </td>
                    <td style="padding: 14px; max-width: 320px;">
                        @if($r->review_title)
                            <strong style="display: block; color: var(--text-heading); margin-bottom: 2px;">{{ $r->review_title }}</strong>
                        @endif
                        <span style="color: #64748b; font-size: 12px;">{{ $r->review_text }}</span>
                    </td>
                    <td style="padding: 14px; font-family: monospace; color: var(--primary);">
                        #{{ $r->booking_id }}
                    </td>
                    <td style="padding: 14px;">
                        <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: {{ $r->admin_status === 'approved' ? '#dcfce7' : '#fee2e2' }}; color: {{ $r->admin_status === 'approved' ? '#15803d' : '#b91c1c' }}; text-transform: capitalize;">
                            {{ $r->admin_status }}
                        </span>
                    </td>
                    <td style="padding: 14px; text-align: right; white-space: nowrap;">
                        <form method="POST" action="{{ route('admin.ratings.toggle', $r->id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline" style="padding: 4px 10px; font-size: 11px; border-radius: 12px; border: 1px solid #cbd5e1;">
                                {{ $r->admin_status === 'approved' ? 'Hide' : 'Publish' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.ratings.destroy', $r->id) }}" style="display: inline;" onsubmit="return confirm('Permanently delete this review?');">
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
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">No reviews found for this filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $ratings->links() }}
    </div>
</div>
@endsection
