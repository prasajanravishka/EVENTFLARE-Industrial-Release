@extends('layouts.eventflare')

@section('title', 'EVENTFLARE — Curated Event Planning & Marketplace')

@push('styles')
<style>
    .home-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .hero-section {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 50px;
        align-items: center;
        padding: 50px 0 80px;
    }
    .hero-title {
        font-size: 46px;
        font-weight: 900;
        line-height: 1.2;
        margin-bottom: 20px;
        color: var(--text-heading);
    }
    .hero-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #ec4899 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .hero-subtitle {
        font-size: 17px;
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 30px;
    }
    .hero-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(139, 92, 246, 0.1);
        color: var(--primary);
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 20px;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }
    .hero-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 30px;
        box-shadow: var(--shadow-premium);
    }
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        padding: 30px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        margin-bottom: 70px;
        text-align: center;
        box-shadow: var(--shadow-premium);
    }
    .stat-number {
        font-size: 32px;
        font-weight: 800;
        color: var(--primary);
    }
    .stat-label {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 600;
    }
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        margin-bottom: 80px;
    }
    .category-card {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 18px;
        padding: 26px 20px;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    }
    .category-card:hover {
        transform: translateY(-6px);
        border-color: var(--primary);
        box-shadow: 0 16px 32px rgba(139, 92, 246, 0.15);
    }
    .category-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 16px;
        border-radius: 16px;
        background: rgba(139, 92, 246, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }
    .category-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-heading);
        margin-bottom: 6px;
    }
    .category-desc {
        font-size: 13px;
        color: var(--text-muted);
    }
    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
        margin-bottom: 80px;
    }
    .review-card {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    }
    .stars {
        color: #f59e0b;
        margin-bottom: 12px;
    }
    .review-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-heading);
        margin-bottom: 8px;
    }
    .review-text {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 16px;
    }
    .reviewer-meta {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }
    .contact-wrapper {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 50px;
        margin-bottom: 80px;
        box-shadow: var(--shadow-premium);
    }
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 50px;
    }
    @media(max-width: 900px) {
        .hero-section { grid-template-columns: 1fr; }
        .stats-bar { grid-template-columns: 1fr 1fr; }
        .contact-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="home-container">
    <!-- 1. HERO SECTION -->
    <section class="hero-section" id="hero">
        <div>
            <div class="hero-badge-pill">
                <i class="fas fa-crown"></i> Sri Lanka's Premier Event Marketplace
            </div>
            <h1 class="hero-title">
                Elevating Celebrations <span>Beyond Expectation.</span>
            </h1>
            <p class="hero-subtitle">
                Connect with handpicked, vetted wedding florists, traditional Poruwa masters, concert audio engineers, and five-star beachside hotels — all backed by transparent upfront pricing and intelligent budgeting.
            </p>
            <div class="hero-actions">
                <a href="{{ route('events.index') }}" class="btn btn-primary" style="padding: 14px 28px; font-size: 15px;">
                    <i class="fas fa-compass"></i> Explore Event Categories
                </a>
                <a href="{{ route('food-calculator') }}" class="btn btn-secondary" style="padding: 14px 28px; font-size: 15px;">
                    <i class="fas fa-calculator"></i> Food Budget Tool
                </a>
            </div>
        </div>

        <div>
            <div class="hero-card">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="Eventflare Logo" style="width: 80px; height: 80px; border-radius: 20px; object-fit: cover; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.25);" onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=100'">
                    <h3 style="margin-top: 14px; font-size: 20px;">Ready to Plan?</h3>
                    <p style="color: var(--text-muted); font-size: 14px;">Instant booking with certified vendor assignments</p>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="{{ route('events.weddings') }}" class="btn btn-outline" style="border: 1px solid #e2e8f0; justify-content: flex-start; padding: 12px 18px; color: var(--text-heading);">
                        <i class="fas fa-ring" style="color: #ec4899;"></i> Royal Weddings Showcase
                    </a>
                    <a href="{{ route('events.dj-parties') }}" class="btn btn-outline" style="border: 1px solid #e2e8f0; justify-content: flex-start; padding: 12px 18px; color: var(--text-heading);">
                        <i class="fas fa-music" style="color: #8b5cf6;"></i> DJ Parties & Concert Audio
                    </a>
                    <a href="{{ route('events.birthdays') }}" class="btn btn-outline" style="border: 1px solid #e2e8f0; justify-content: flex-start; padding: 12px 18px; color: var(--text-heading);">
                        <i class="fas fa-birthday-cake" style="color: #f59e0b;"></i> Milestone Birthdays
                    </a>
                    <a href="{{ route('events.hotels') }}" class="btn btn-outline" style="border: 1px solid #e2e8f0; justify-content: flex-start; padding: 12px 18px; color: var(--text-heading);">
                        <i class="fas fa-hotel" style="color: #3b82f6;"></i> 5-Star Hotel Venues
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. PLATFORM METRICS -->
    <div class="stats-bar">
        <div>
            <div class="stat-number">10+</div>
            <div class="stat-label">Vetted Service Categories</div>
        </div>
        <div>
            <div class="stat-number">27+</div>
            <div class="stat-label">Verified Packages</div>
        </div>
        <div>
            <div class="stat-number">100%</div>
            <div class="stat-label">Transparent Pricing</div>
        </div>
        <div>
            <div class="stat-number">5.0 ★</div>
            <div class="stat-label">Average Satisfaction</div>
        </div>
    </div>

    <!-- 3. FIVE EVENT UNIVERSES -->
    <section class="page-section" id="services">
        <div style="text-align: center; margin-bottom: 40px;">
            <div class="hero-badge-pill">
                <i class="fas fa-sparkles"></i> Curated Collections
            </div>
            <h2 style="font-size: 34px; font-weight: 800;">Choose Your Celebration Universe</h2>
            <p style="color: var(--text-muted); font-size: 15px; max-width: 600px; margin: 8px auto 0;">Explore tailored service packages and transparent price points for every occasion.</p>
        </div>

        <div class="category-grid">
            <a href="{{ route('events.weddings') }}" class="category-card">
                <div class="category-icon" style="background: rgba(236, 72, 153, 0.1); color: #ec4899;">
                    <i class="fas fa-ring"></i>
                </div>
                <div class="category-title">Weddings</div>
                <div class="category-desc">Poruwa rituals, floral backdrops, traditional dancers, 4K drone cinematography.</div>
            </a>

            <a href="{{ route('events.dj-parties') }}" class="category-card">
                <div class="category-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                    <i class="fas fa-compact-disc"></i>
                </div>
                <div class="category-title">DJ Parties</div>
                <div class="category-desc">Heavy bass line arrays, intelligent moving heads, VIP security & cocktail bars.</div>
            </a>

            <a href="{{ route('events.birthdays') }}" class="category-card">
                <div class="category-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-birthday-cake"></i>
                </div>
                <div class="category-title">Birthdays</div>
                <div class="category-desc">Artisan custom cakes, organic balloon arches, magicians & themed kids buffets.</div>
            </a>

            <a href="{{ route('events.hotels') }}" class="category-card">
                <div class="category-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                    <i class="fas fa-hotel"></i>
                </div>
                <div class="category-title">Hotel Venues</div>
                <div class="category-desc">Grand oceanfront ballrooms, plated luncheons, VIP suites & valet coordination.</div>
            </a>

            <a href="{{ route('events.get-together') }}" class="category-card">
                <div class="category-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="category-title">Get-Togethers</div>
                <div class="category-desc">Lawn furniture rentals, acoustic trios, live charcoal BBQ skewer stations.</div>
            </a>
        </div>
    </section>

    <!-- 4. VERIFIED REVIEWS -->
    <section class="page-section" id="reviews">
        <div style="text-align: center; margin-bottom: 40px;">
            <div class="hero-badge-pill">
                <i class="fas fa-star"></i> Real Experiences
            </div>
            <h2 style="font-size: 34px; font-weight: 800;">What Our Clients Say</h2>
            <p style="color: var(--text-muted); font-size: 15px;">Verified reviews from real hosts and celebration coordinators.</p>
        </div>

        <div class="reviews-grid">
            @forelse($reviews as $r)
                <div class="review-card">
                    <div class="stars">
                        @for($i=1; $i<=$r->rating; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </div>
                    <div class="review-title">{{ $r->review_title ?: 'Exceptional Experience' }}</div>
                    <div class="review-text">"{{ $r->review_text }}"</div>
                    <div class="reviewer-meta">
                        <div class="avatar-circle">
                            {{ strtoupper(substr($r->user->fullname ?? $r->user->username ?? 'V', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 14px; color: var(--text-heading);">
                                {{ $r->user->fullname ?? $r->user->username ?? 'Verified Client' }}
                            </div>
                            <div style="font-size: 12px; color: var(--text-muted);">
                                {{ $r->supplier->business_name ?? 'Partner Vendor' }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p style="text-align:center; color:var(--text-muted); grid-column:1/-1;">No reviews published yet.</p>
            @endforelse
        </div>
    </section>

    <!-- 5. ABOUT US -->
    <section class="page-section" id="about">
        <div style="background: rgba(139, 92, 246, 0.04); border: 1px solid var(--card-border); border-radius: 24px; padding: 50px 40px; margin-bottom: 80px;">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <div class="hero-badge-pill">
                    <i class="fas fa-heart"></i> The Eventflare Mission
                </div>
                <h2 style="font-size: 32px; font-weight: 800; margin-bottom: 16px;">Built to Eliminate Celebration Stress</h2>
                <p style="color: var(--text-muted); font-size: 16px; line-height: 1.8; margin-bottom: 24px;">
                    Event planning in Sri Lanka has historically been fragmented — endless WhatsApp inquiries, vague quotes, and double-booking anxieties. EVENTFLARE unifies the entire lifecycle: discovery, verified inventory, itemized cost calculators, and seamless supplier coordination under one transparent roof.
                </p>
                <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('events.index') }}" class="btn btn-primary">Discover Services</a>
                    <a href="{{ route('supplier.register') }}" class="btn btn-outline" style="border: 1px solid #e2e8f0;">Become a Partner Vendor</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. CONTACT FORM -->
    <section class="page-section" id="contact">
        <div class="contact-wrapper">
            <div class="contact-grid">
                <div>
                    <div class="hero-badge-pill">
                        <i class="fas fa-headset"></i> Concierge Desk
                    </div>
                    <h2 style="font-size: 32px; font-weight: 800; margin-bottom: 14px;">Let's Plan Something Extraordinary</h2>
                    <p style="color: var(--text-muted); line-height: 1.7; margin-bottom: 24px;">
                        Have questions about venue availability, bespoke multi-day packages, or vendor partnerships? Send our planning specialists an inquiry.
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 14px; color: var(--text-muted); font-size: 14px;">
                        <div><i class="fas fa-map-marker-alt" style="color: var(--primary); margin-right: 8px;"></i> Colombo & Island-wide, Sri Lanka</div>
                        <div><i class="fas fa-phone-alt" style="color: var(--primary); margin-right: 8px;"></i> +94 11 269 4820</div>
                        <div><i class="fas fa-envelope" style="color: var(--primary); margin-right: 8px;"></i> concierge@eventflare.com</div>
                    </div>
                </div>

                <div>
                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <input type="text" name="firstname" value="{{ old('firstname') }}" class="form-input" placeholder="First Name" required>
                            </div>
                            <div>
                                <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-input" placeholder="Last Name" required>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="Email Address" required>
                            </div>
                            <div>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="Mobile Number (+94 ...)" required>
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <textarea name="message" rows="4" class="form-input" placeholder="Describe your celebration (approximate date, guest count, desired services)..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 15px;">
                            <i class="fas fa-paper-plane"></i> Send Inquiry to Concierge
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection