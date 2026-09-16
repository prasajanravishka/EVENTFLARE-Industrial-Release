@extends('layouts.admin', ['activePage' => 'staff', 'title' => 'Staff & Admins - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <h1>Platform Administrators & Staff</h1>
        <p>Manage system operators authorized to oversee bookings, vendors, and audit catalogs.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
    <!-- Admins Table -->
    <div class="glass-card" style="padding: 24px; overflow-x: auto;">
        <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
            <i class="fas fa-shield-alt" style="color: var(--primary); margin-right: 6px;"></i> Active Administrators ({{ $admins->count() }})
        </h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
            <thead>
                <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 10px 12px;">Admin Username</th>
                    <th style="padding: 10px 12px;">Full Name</th>
                    <th style="padding: 10px 12px;">Email</th>
                    <th style="padding: 10px 12px;">Provisioned</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $a)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px;">
                            <strong style="color: var(--primary);">@<span>{{ $a->username }}</span></strong>
                        </td>
                        <td style="padding: 12px; font-weight: 700;">{{ $a->fullname }}</td>
                        <td style="padding: 12px; color: #64748b;">{{ $a->email }}</td>
                        <td style="padding: 12px; color: #64748b;">{{ $a->created_at ? $a->created_at->format('M d, Y') : '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Provision New Admin Form -->
    <div class="glass-card" style="padding: 22px;">
        <h3 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 14px;">
            <i class="fas fa-user-plus" style="color: var(--primary); margin-right: 6px;"></i> Provision Administrator
        </h3>
        <form method="POST" action="{{ route('admin.staff.store') }}">
            @csrf
            <div style="margin-bottom: 12px;">
                <label class="form-label" for="username">Staff Username <span style="color:#ef4444;">*</span></label>
                <input type="text" id="username" name="username" class="form-input" required placeholder="e.g. jdoe_admin">
                @error('username') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label class="form-label" for="fullname">Full Name <span style="color:#ef4444;">*</span></label>
                <input type="text" id="fullname" name="fullname" class="form-input" required placeholder="e.g. John Doe">
                @error('fullname') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label class="form-label" for="email">Work Email <span style="color:#ef4444;">*</span></label>
                <input type="email" id="email" name="email" class="form-input" required placeholder="e.g. jdoe@eventflare.lk">
                @error('email') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label class="form-label" for="password">Password (min 6 chars) <span style="color:#ef4444;">*</span></label>
                <input type="password" id="password" name="password" class="form-input" required>
                @error('password') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 18px;">
                <label class="form-label" for="password_confirmation">Confirm Password <span style="color:#ef4444;">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; border-radius: 20px; font-weight: 700; font-size: 13px;">
                Provision Admin Account
            </button>
        </form>
    </div>
</div>
@endsection
