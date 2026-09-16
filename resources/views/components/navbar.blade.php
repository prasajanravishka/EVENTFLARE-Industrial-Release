<header class="navbar-header">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=100'">
                EVENTFLARE
            </a>
        </div>

        <!-- Mobile Toggle -->
        <div class="mobile-toggle" id="mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </div>

        <!-- Navbar Links -->
        <ul class="nav-menu" id="nav-menu">
            <li><a href="{{ url('/#hero') }}" class="nav-link">Home</a></li>
            <li><a href="{{ route('marketplace.index') }}" class="nav-link"><i class="fas fa-store"></i> Marketplace</a></li>
            <li><a href="{{ url('/#services') }}" class="nav-link">Services</a></li>
            <li><a href="{{ url('/#about') }}" class="nav-link">About</a></li>
            <li><a href="{{ url('/#reviews') }}" class="nav-link">Reviews</a></li>
            <li><a href="{{ url('/#contact') }}" class="nav-link">Contact</a></li>

            @auth
                @if(Auth::user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-shield-alt"></i> Admin Panel</a></li>
                @elseif(Auth::user()->isSupplier())
                    <li><a href="{{ route('supplier.dashboard') }}" class="nav-link"><i class="fas fa-briefcase"></i> Supplier Portal</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-compass"></i> Event Hub</a></li>
                    <li><a href="{{ route('client.bookings') }}" class="nav-link"><i class="fas fa-calendar-alt"></i> My Bookings</a></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-secondary" style="border-radius:30px; padding: 7px 18px; font-size: 13px; border:none; cursor:pointer;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="nav-link">Sign In</a></li>
                <li><a href="{{ route('register') }}" class="nav-link btn btn-primary" style="border-radius:30px; padding: 7px 18px; font-size: 13px; color:#fff;">Sign Up</a></li>
            @endauth
        </ul>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('nav-menu');
        if (toggle && menu) {
            toggle.addEventListener('click', function () {
                menu.classList.toggle('active');
            });
        }
    });
</script>
