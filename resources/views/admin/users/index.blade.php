@extends('layouts.admin', ['activePage' => 'users', 'title' => 'Client Accounts - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <h1>Client Accounts Ledger</h1>
        <p>Manage verified customer profiles, contact credentials, and reservation histories.</p>
    </div>
</div>

<!-- Search Bar -->
<div class="glass-card" style="padding: 20px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.users.index') }}" style="display: flex; gap: 14px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <input type="text" name="search" class="form-input" placeholder="Search by username, full name, or email..." value="{{ $search }}">
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 20px; font-weight: 700;">
            <i class="fas fa-search"></i> Search Clients
        </button>
        @if($search)
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="padding: 10px 16px; border-radius: 20px;">Clear</a>
        @endif
    </form>
</div>

<!-- Users Table -->
<div class="glass-card" style="padding: 24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
        <thead>
            <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px;">User</th>
                <th style="padding: 12px 14px;">Full Name</th>
                <th style="padding: 12px 14px;">Email Address</th>
                <th style="padding: 12px 14px;">Bookings Made</th>
                <th style="padding: 12px 14px;">Registration Date</th>
                <th style="padding: 12px 14px; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $u)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 14px;">
                        <strong style="color: var(--primary);">@<span>{{ $u->username }}</span></strong>
                    </td>
                    <td style="padding: 14px; font-weight: 700; color: var(--text-heading);">
                        {{ $u->fullname ?: '—' }}
                    </td>
                    <td style="padding: 14px; color: #64748b;">
                        {{ $u->email }}
                    </td>
                    <td style="padding: 14px; font-weight: 800; color: var(--primary);">
                        {{ $u->bookings_count }}
                    </td>
                    <td style="padding: 14px; color: #64748b;">
                        {{ $u->created_at ? $u->created_at->format('M d, Y') : '—' }}
                    </td>
                    <td style="padding: 14px; text-align: right;">
                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Permanently delete account @{{ $u->username }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="border: 1px solid #fee2e2; color: #ef4444; padding: 4px 10px; font-size: 11px; border-radius: 12px;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">No client accounts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
