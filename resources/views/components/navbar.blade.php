<header class="navbar-header">
    <div class="navbar-container">
        <!-- Brand Logo -->
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.jpg') }}" alt="EVENTFLARE" onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=100'">
                EVENTFLARE
            </a>
        </div>

        <!-- Mobile Toggle Button -->
        <button type="button" class="mobile-toggle" id="mobile-menu-toggle" aria-label="Toggle Navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar Links -->
        <ul class="nav-menu" id="nav-menu">
            <li>
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>
            </li>
         <!--            <li>
                <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i> Events
                </a>
            </li> -->
            <li>
                <a href="{{ route('marketplace.index') }}" class="nav-link {{ request()->routeIs('marketplace.*') ? 'active' : '' }}">
                    <i class="fas fa-store"></i> Marketplace
                </a>
            </li>
            <li>
                <a href="{{ url('/#services') }}" class="nav-link">
                    Services
                </a>
            </li>

            <li>
                <a href="{{ url('/#reviews') }}" class="nav-link">
                    Reviews
                </a>
            </li>
            <li>
                <a href="{{ url('/#about') }}" class="nav-link">
                    About
                </a>
            </li>

            <li>
                <a href="{{ url('/#contact') }}" class="nav-link">
                    Contact
                </a>
            </li>

            @auth
                @if(Auth::user()->isAdmin())
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link" style="color: #7c3aed; font-weight: 700;">
                            <i class="fas fa-shield-alt"></i> Admin Panel
                        </a>
                    </li>
                @elseif(Auth::user()->isSupplier())
                    <li>
                        <a href="{{ route('supplier.dashboard') }}" class="nav-link" style="color: #7c3aed; font-weight: 700;">
                            <i class="fas fa-briefcase"></i> Supplier Portal
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-compass"></i> Event Hub
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.bookings') }}" class="nav-link {{ request()->routeIs('client.bookings*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i> My Bookings
                        </a>
                    </li>
                @endif

                <!-- User Profile & Avatar -->
                <li>
                    <a href="{{ route('profile.edit') }}" class="nav-user-chip" title="Account Settings">
                        <span class="nav-avatar-circle">
                            {{ strtoupper(substr(Auth::user()->fullname ?? Auth::user()->name ?? Auth::user()->username ?? 'U', 0, 1)) }}
                        </span>
                        <span>{{ Str::limit(Auth::user()->fullname ?? Auth::user()->name ?? Auth::user()->username ?? 'User', 14) }}</span>
                    </a>
                </li>

                <!-- Logout -->
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline; margin:0;">
                        @csrf
                        <button type="submit" class="nav-link" style="background: rgba(239, 68, 68, 0.08); color: #dc2626; border-radius: 8px; border: 1px solid rgba(239, 68, 68, 0.2); cursor: pointer; padding: 7px 13px; font-weight: 600; width: 100%;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                        Sign In
                    </a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="nav-link btn btn-primary" style="border-radius:30px; padding: 8px 18px; font-size: 13px; color:#ffffff; font-weight:700; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.3);">
                        Sign Up
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</header>

<!-- Mobile Drawer Backdrop -->
<div class="nav-backdrop" id="nav-backdrop"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('nav-menu');
        const backdrop = document.getElementById('nav-backdrop');

        if (toggle && menu) {
            function toggleMenu() {
                const isActive = menu.classList.toggle('active');
                if (backdrop) backdrop.classList.toggle('active', isActive);
                const icon = toggle.querySelector('i');
                if (icon) {
                    if (isActive) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            }

            function closeMenu() {
                menu.classList.remove('active');
                if (backdrop) backdrop.classList.remove('active');
                const icon = toggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }

            toggle.addEventListener('click', toggleMenu);
            if (backdrop) backdrop.addEventListener('click', closeMenu);

            menu.querySelectorAll('.nav-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 1024) {
                        closeMenu();
                    }
                });
            });
        }
    });
</script>
