@props(['activePage' => 'dashboard'])

@php
    $pendingBookings = \App\Models\Booking::where('status', 'pending')->count();
    $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
    $totalClients = \App\Models\User::whereIn('role', ['buyer', 'supplier'])->count();
    $pendingReviews = \App\Models\Rating::where('admin_status', 'pending')->count();
    $currentAdmin = Auth::user()->username ?? 'Admin';
    $adminInitial = strtoupper(substr($currentAdmin, 0, 1));
@endphp

<!-- Mobile Drawer Toggle Header -->
<div class="mobile-admin-header">
    <button type="button" class="sidebar-toggle-btn" id="adminSidebarToggle" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>
    <a href="{{ route('admin.dashboard') }}" class="mobile-brand">EVENTFLARE</a>
    <div class="mobile-user-avatar">
        <i class="fas fa-user-shield"></i>
    </div>
</div>

<aside class="dashboard-sidebar" id="adminSidebar">
    <div class="sidebar-top">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.jpg') }}" alt="Eventflare Logo" onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=100'">
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-title">EVENTFLARE</span>
                <span class="sidebar-brand-badge">ADMIN CONSOLE</span>
            </div>
        </a>
        <button type="button" class="sidebar-close-btn" id="adminSidebarClose" aria-label="Close sidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <ul class="sidebar-menu">
        <li class="sidebar-section-header">Core Console</li>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ $activePage === 'dashboard' ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Overview
            </a>
        </li>
        <li>
            <a href="{{ route('admin.event-types.index') }}" class="{{ $activePage === 'event_types' ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Event Types
            </a>
        </li>
        <li>
            <a href="{{ route('admin.portfolio.index') }}" class="{{ $activePage === 'portfolio' ? 'active' : '' }}">
                <i class="fas fa-photo-video"></i> Portfolio & Case Studies
            </a>
        </li>

        <li class="sidebar-section-header">People & Accounts</li>
        <li>
            <a href="{{ route('admin.users.index') }}" class="{{ in_array($activePage, ['users', 'suppliers']) ? 'active' : '' }}">
                <i class="fas fa-users"></i> Clients
                @if($totalClients > 0)
                    <span class="sidebar-badge badge-neutral">{{ $totalClients }}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('admin.ratings.index') }}" class="{{ $activePage === 'ratings' ? 'active' : '' }}">
                <i class="fas fa-star"></i> Ratings & Reviews
                @if($pendingReviews > 0)
                    <span class="sidebar-badge badge-warning">{{ $pendingReviews }}</span>
                @endif
            </a>
        </li>

        <li class="sidebar-section-header">Event Operations</li>
        <li>
            <a href="{{ route('admin.bookings.index') }}" class="{{ $activePage === 'bookings' ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Bookings
                @if($pendingBookings > 0)
                    <span class="sidebar-badge badge-warning">{{ $pendingBookings }}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('admin.budgets.index') }}" class="{{ $activePage === 'budgets' ? 'active' : '' }}">
                <i class="fas fa-wallet"></i> Budgets
            </a>
        </li>

        <li class="sidebar-section-header">Platform & Security</li>
        <li>
            <a href="{{ route('admin.messages.index') }}" class="{{ $activePage === 'messages' ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Inquiries
                @if($unreadMessages > 0)
                    <span class="sidebar-badge badge-primary">{{ $unreadMessages }}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('admin.staff.index') }}" class="{{ $activePage === 'staff' ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Staff & Admins
            </a>
        </li>
    </ul>

    <div class="sidebar-bottom">
        <div class="sidebar-user-card">
            <div class="sidebar-user-avatar">
                {{ $adminInitial }}
                <span class="sidebar-status-dot" title="Active Session"></span>
            </div>
            <div class="sidebar-user-meta">
                <div class="sidebar-user-name" title="{{ $currentAdmin }}">
                    {{ $currentAdmin }}
                </div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
            <div class="sidebar-user-actions">
                <a href="{{ url('/') }}" class="sidebar-icon-btn" title="View Live Site" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="sidebar-icon-btn logout" title="Sign Out" style="background:none; border:none; cursor:pointer;">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

        <a href="{{ url('/') }}" class="sidebar-link-home-pill" target="_blank">
            <i class="fas fa-globe"></i> View Public Website
        </a>
    </div>
</aside>

<div class="sidebar-backdrop" id="adminSidebarBackdrop"></div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('adminSidebarToggle');
    const closeBtn = document.getElementById('adminSidebarClose');
    const sidebar = document.getElementById('adminSidebar');
    const backdrop = document.getElementById('adminSidebarBackdrop');

    function openSidebar() {
        sidebar.classList.add('mobile-open');
        backdrop.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('mobile-open');
        backdrop.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (backdrop) backdrop.addEventListener('click', closeSidebar);
});
</script>
