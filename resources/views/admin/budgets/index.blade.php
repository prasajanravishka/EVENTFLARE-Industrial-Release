@extends('layouts.admin', ['activePage' => 'budgets', 'title' => 'Financial Budgets - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <h1>Financial & Catering Budget Ledger</h1>
        <p>Monitor event catering computations, food pricing tier choices, and client budget envelopes.</p>
    </div>
</div>

<!-- Aggregated Metrics Grid -->
<div class="stat-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="glass-card" style="padding: 18px;">
        <small style="color: var(--text-muted); font-size: 11px; font-weight: 700; text-transform: uppercase;">Total Budget Envelopes</small>
        <div style="font-size: 22px; font-weight: 900; color: var(--text-heading); margin-top: 4px;">
            LKR {{ number_format($totals['total_budget']) }}
        </div>
    </div>
    <div class="glass-card" style="padding: 18px;">
        <small style="color: var(--text-muted); font-size: 11px; font-weight: 700; text-transform: uppercase;">Allocated Food Budgets</small>
        <div style="font-size: 22px; font-weight: 900; color: var(--primary); margin-top: 4px;">
            LKR {{ number_format($totals['food_budget']) }}
        </div>
    </div>
    <div class="glass-card" style="padding: 18px;">
        <small style="color: var(--text-muted); font-size: 11px; font-weight: 700; text-transform: uppercase;">Total Computed Catering</small>
        <div style="font-size: 22px; font-weight: 900; color: #059669; margin-top: 4px;">
            LKR {{ number_format($totals['total_spent']) }}
        </div>
    </div>
    <div class="glass-card" style="padding: 18px;">
        <small style="color: var(--text-muted); font-size: 11px; font-weight: 700; text-transform: uppercase;">Saved Calculations</small>
        <div style="font-size: 22px; font-weight: 900; color: #3b82f6; margin-top: 4px;">
            {{ $totals['count'] }}
        </div>
    </div>
</div>

<!-- Budgets Table -->
<div class="glass-card" style="padding: 24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
        <thead>
            <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px;">Log ID</th>
                <th style="padding: 12px 14px;">User</th>
                <th style="padding: 12px 14px;">Booking ID</th>
                <th style="padding: 12px 14px;">Total Budget</th>
                <th style="padding: 12px 14px;">Food Budget</th>
                <th style="padding: 12px 14px;">Computed Total</th>
                <th style="padding: 12px 14px;">Surplus / Deficit</th>
                <th style="padding: 12px 14px;">Date Calculated</th>
            </tr>
        </thead>
        <tbody>
            @forelse($budgets as $b)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 14px; font-weight: 800; font-family: monospace;">#{{ $b->id }}</td>
                    <td style="padding: 14px; font-weight: 700;">{{ $b->user_name }}</td>
                    <td style="padding: 14px; font-family: monospace; color: var(--primary);">{{ $b->booking_id ?: 'Standalone' }}</td>
                    <td style="padding: 14px;">LKR {{ number_format($b->total_budget) }}</td>
                    <td style="padding: 14px; color: var(--primary); font-weight: 700;">LKR {{ number_format($b->food_budget) }}</td>
                    <td style="padding: 14px; font-weight: 800; color: #059669;">LKR {{ number_format($b->total_spent) }}</td>
                    <td style="padding: 14px;">
                        <span style="font-size: 11px; font-weight: 800; color: {{ $b->variance >= 0 ? '#15803d' : '#b91c1c' }};">
                            {{ $b->variance >= 0 ? '+ LKR ' . number_format($b->variance) : '- LKR ' . number_format(abs($b->variance)) }}
                        </span>
                    </td>
                    <td style="padding: 14px; color: #64748b;">{{ $b->created_at ? $b->created_at->format('M d, Y') : '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">No budget calculation records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $budgets->links() }}
    </div>
</div>
@endsection
