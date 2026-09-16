@extends('layouts.admin', ['activePage' => 'messages', 'title' => 'Inquiries - EVENTFLARE Admin Console'])

@section('content')
<div class="dashboard-header">
    <div class="dashboard-title">
        <h1>Customer Inquiries & Messages</h1>
        <p>Inbound questions submitted via the public contact forms across Sri Lanka.</p>
    </div>
</div>

<!-- Filter Tabs -->
<div class="glass-card" style="padding: 16px; margin-bottom: 24px; display: flex; gap: 10px; flex-wrap: wrap;">
    <a href="{{ route('admin.messages.index', ['filter' => 'all']) }}" class="btn {{ $filter === 'all' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 8px 18px; border-radius: 20px; font-size: 13px;">
        All Messages
    </a>
    <a href="{{ route('admin.messages.index', ['filter' => 'unread']) }}" class="btn {{ $filter === 'unread' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 8px 18px; border-radius: 20px; font-size: 13px;">
        Unread Inquiries
    </a>
    <a href="{{ route('admin.messages.index', ['filter' => 'read']) }}" class="btn {{ $filter === 'read' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 8px 18px; border-radius: 20px; font-size: 13px;">
        Read Inquiries
    </a>
</div>

<!-- Messages Table -->
<div class="glass-card" style="padding: 24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
        <thead>
            <tr style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px;">Sender</th>
                <th style="padding: 12px 14px;">Email & Phone</th>
                <th style="padding: 12px 14px;">Message Details</th>
                <th style="padding: 12px 14px;">Status</th>
                <th style="padding: 12px 14px;">Received</th>
                <th style="padding: 12px 14px; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $m)
                <tr style="border-bottom: 1px solid #f1f5f9; background: {{ $m->is_read ? 'transparent' : '#f8fafc' }};">
                    <td style="padding: 14px;">
                        <strong style="color: var(--text-heading);">{{ $m->firstname }} {{ $m->lastname }}</strong>
                    </td>
                    <td style="padding: 14px;">
                        <div>{{ $m->email }}</div>
                        <small style="color: #64748b;">{{ $m->phone ?: '—' }}</small>
                    </td>
                    <td style="padding: 14px; max-width: 380px; color: #475569;">
                        {{ $m->message }}
                    </td>
                    <td style="padding: 14px;">
                        <span style="font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 10px; background: {{ $m->is_read ? '#e2e8f0' : '#fef3c7' }}; color: {{ $m->is_read ? '#475569' : '#b45309' }};">
                            {{ $m->is_read ? 'Read' : 'New' }}
                        </span>
                    </td>
                    <td style="padding: 14px; color: #64748b;">
                        {{ $m->created_at ? $m->created_at->format('M d, Y') : '—' }}
                    </td>
                    <td style="padding: 14px; text-align: right; white-space: nowrap;">
                        <form method="POST" action="{{ route('admin.messages.toggle', $m->id) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline" style="padding: 4px 10px; font-size: 11px; border-radius: 12px; border: 1px solid #cbd5e1;">
                                {{ $m->is_read ? 'Mark Unread' : 'Mark Read' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.messages.destroy', $m->id) }}" style="display: inline;" onsubmit="return confirm('Delete this inquiry?');">
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
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">No contact inquiries found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $messages->links() }}
    </div>
</div>
@endsection
