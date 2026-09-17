<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'EVENTFLARE — Premium Event Planning & Management Platform' }}</title>

    <!-- Design Tokens & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">

    @stack('styles')
</head>
<body>
    <!-- Main Floating Glass Navbar -->
    <x-navbar />

    <!-- Flash Alert Notifications -->
    <div style="max-width: 1200px; margin: 20px auto 0; padding: 0 20px;">
        <x-flash-message />
    </div>

    <!-- Main View Content -->
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Global Industrial Footer -->
    <footer style="background: #0f172a; color: #94a3b8; padding: 60px 40px 30px 40px; margin-top: 80px; border-top: 1px solid rgba(255,255,255,0.05); box-sizing: border-box;">
        <div style="max-width: 100%; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 40px; margin-bottom: 40px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="EVENTFLARE" style="height: 36px;" onerror="this.style.display='none'">
                    <span style="font-size: 22px; font-weight: 900; color: #ffffff; letter-spacing: 0.5px;">EVENT<span style="color: #a855f7;">FLARE</span></span>
                </div>
                <p style="font-size: 14px; line-height: 1.6; color: #94a3b8; margin-bottom: 20px;">
                    Sri Lanka's leading digital platform for verified event suppliers, wedding poruwa artisans, concert audio systems, and luxury hospitality venues.
                </p>
                <div style="font-size: 12px; color: #64748b;">
                    <i class="fas fa-shield-alt" style="color: #10b981;"></i> Sri Lanka PDPA Compliant &bull; TLS 1.3
                </div>
            </div>

            <div>
                <h4 style="color: #ffffff; font-size: 15px; font-weight: 800; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Event Categories</h4>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; line-height: 2.2;">
                    <li><a href="{{ route('events.weddings') }}" style="color: #94a3b8; text-decoration: none;">Royal Weddings & Poruwa</a></li>
                    <li><a href="{{ route('events.dj-parties') }}" style="color: #94a3b8; text-decoration: none;">DJ & Festival Sound</a></li>
                    <li><a href="{{ route('events.birthdays') }}" style="color: #94a3b8; text-decoration: none;">Milestone Birthdays</a></li>
                    <li><a href="{{ route('events.hotels') }}" style="color: #94a3b8; text-decoration: none;">Hotel Venues & Banquets</a></li>
                    <li><a href="{{ route('events.get-together') }}" style="color: #94a3b8; text-decoration: none;">Corporate & Reunions</a></li>
                </ul>
            </div>

            <div>
                <h4 style="color: #ffffff; font-size: 15px; font-weight: 800; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Platform Links</h4>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; line-height: 2.2;">
                    <li><a href="{{ route('marketplace.index') }}" style="color: #94a3b8; text-decoration: none;">Supplier Marketplace</a></li>
                    <li><a href="{{ route('food-calculator') }}" style="color: #94a3b8; text-decoration: none;">Food & Budget Calculator</a></li>
                    <li><a href="{{ route('about') }}" style="color: #94a3b8; text-decoration: none;">About EVENTFLARE</a></li>
                    <li><a href="{{ route('supplier.register') }}" style="color: #a855f7; font-weight: 700; text-decoration: none;">Join as a Supplier</a></li>
                </ul>
            </div>

            <div>
                <h4 style="color: #ffffff; font-size: 15px; font-weight: 800; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Legal & Compliance</h4>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; line-height: 2.2;">
                    <li><a href="{{ route('terms') }}" style="color: #94a3b8; text-decoration: none;">Terms of Service</a></li>
                    <li><a href="{{ route('privacy') }}" style="color: #94a3b8; text-decoration: none;">Privacy & Data Protection</a></li>
                    <li><a href="mailto:dpo@eventflare.lk" style="color: #94a3b8; text-decoration: none;">Data Protection Officer</a></li>
                    <li><a href="{{ route('home') }}#contact" style="color: #94a3b8; text-decoration: none;">Support Desk</a></li>
                </ul>
            </div>
        </div>

        <div style="max-width: 100%; margin: 0 auto; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; font-size: 13px;">
            <div>&copy; {{ date('Y') }} EVENTFLARE Platform. All Rights Reserved. Designed for Sri Lanka.</div>
            <div style="display: flex; gap: 20px;">
                <a href="{{ route('terms') }}" style="color: #64748b; text-decoration: none;">Terms</a>
                <a href="{{ route('privacy') }}" style="color: #64748b; text-decoration: none;">Privacy Policy</a>
            </div>
        </div>
    </footer>

    <!-- Cookie Consent Banner (PDPA Compliant) -->
    <div id="cookieConsentBanner" style="display: none; position: fixed; bottom: 20px; left: 20px; right: 20px; max-width: 540px; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15); border-radius: 16px; padding: 20px 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); z-index: 99999; color: #e2e8f0; font-size: 13px; line-height: 1.6;">
        <div style="display: flex; align-items: flex-start; gap: 14px;">
            <div style="font-size: 24px; color: #a855f7; flex-shrink: 0; margin-top: 2px;">
                <i class="fas fa-cookie-bite"></i>
            </div>
            <div>
                <h4 style="font-size: 15px; font-weight: 800; color: #ffffff; margin: 0 0 6px 0;">Cookie & Privacy Preferences</h4>
                <p style="margin: 0 0 14px 0; color: #94a3b8;">
                    We use essential cookies to manage your secure session and ensure platform safety in compliance with the Sri Lanka Personal Data Protection Act No. 9 of 2022. Read our <a href="{{ route('privacy') }}" style="color: #c084fc; text-decoration: underline;">Privacy Policy</a>.
                </p>
                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="acceptCookies()" style="background: #a855f7; color: #ffffff; border: none; border-radius: 8px; padding: 7px 18px; font-size: 12px; font-weight: 800; cursor: pointer;">
                        Accept & Continue
                    </button>
                    <button type="button" onclick="dismissCookies()" style="background: transparent; color: #94a3b8; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; padding: 7px 14px; font-size: 12px; cursor: pointer;">
                        Essential Only
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!localStorage.getItem('eventflare_cookies_accepted')) {
                document.getElementById('cookieConsentBanner').style.display = 'block';
            }
        });

        function acceptCookies() {
            localStorage.setItem('eventflare_cookies_accepted', 'all');
            document.getElementById('cookieConsentBanner').style.display = 'none';
        }

        function dismissCookies() {
            localStorage.setItem('eventflare_cookies_accepted', 'essential');
            document.getElementById('cookieConsentBanner').style.display = 'none';
        }
    </script>

    @stack('scripts')
</body>
</html>
