@extends('layouts.eventflare')

@section('title', 'EVENTFLARE — Curated Event Planning & Marketplace')

@push('styles')
<style>
    .home-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .home-container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .hero-section {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 50px;
        align-items: center;
        padding: 40px 0 60px;
        position: relative;
    }
    .hero-title {
        font-size: 52px;
        font-weight: 900;
        line-height: 1.15;
        margin-bottom: 20px;
        color: var(--text-heading);
        letter-spacing: -0.02em;
    }
    .hero-title span {
        background: linear-gradient(135deg, var(--primary) 0%, #ec4899 50%, #f59e0b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .hero-subtitle {
        font-size: 17px;
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 28px;
        max-width: 600px;
    }
    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(139, 92, 246, 0.09);
        color: var(--primary);
        padding: 8px 18px;
        border-radius: 40px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 22px;
        border: 1px solid rgba(139, 92, 246, 0.25);
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.08);
    }
    .hero-pulse-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseGreen 2s infinite;
    }
    @keyframes pulseGreen {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    /* Hero Instant Discovery Search Widget */
    .hero-search-box {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(139, 92, 246, 0.2);
        border-radius: 20px;
        padding: 20px 24px;
        box-shadow: 0 16px 40px -10px rgba(139, 92, 246, 0.16);
        margin-bottom: 28px;
    }
    .hero-search-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr auto;
        gap: 12px;
        align-items: center;
    }
    .hero-field-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .hero-field-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .hero-field-select, .hero-field-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-heading);
        background: #f8fafc;
        outline: none;
        transition: all 0.2s ease;
    }
    .hero-field-select:focus, .hero-field-input:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    }
    .hero-search-btn {
        height: 48px;
        padding: 0 24px;
        background: linear-gradient(135deg, var(--primary) 0%, #7c3aed 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);
        margin-top: 18px;
        white-space: nowrap;
    }
    .hero-search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(139, 92, 246, 0.4);
    }
    .hero-quick-tags {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        font-size: 13px;
        color: var(--text-muted);
    }
    .hero-quick-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid #e2e8f0;
        color: var(--text-main);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .hero-quick-pill:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    /* Visual Showcase Right Column */
    .hero-showcase-wrap {
        position: relative;
    }
    .hero-main-card {
        position: relative;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 25px 60px -15px rgba(26, 18, 56, 0.22);
        background: #1e1b4b;
        aspect-ratio: 4/4.6;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .hero-main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.88;
        transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    .hero-main-card:hover .hero-main-img {
        transform: scale(1.04);
    }
    .hero-card-gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.1) 0%, rgba(15, 23, 42, 0.8) 100%);
    }
    .hero-card-bottom {
        position: absolute;
        bottom: 24px;
        left: 24px;
        right: 24px;
        color: #fff;
    }
    .hero-card-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        background: rgba(236, 72, 153, 0.9);
        color: #fff;
        padding: 4px 10px;
        border-radius: 6px;
        margin-bottom: 8px;
        letter-spacing: 0.05em;
    }
    /* Floating Badges */
    .float-badge-top {
        position: absolute;
        top: -18px;
        right: -16px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(139, 92, 246, 0.25);
        padding: 12px 18px;
        border-radius: 18px;
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.12);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: floatBadge 4.5s ease-in-out infinite alternate;
        z-index: 10;
    }
    .float-badge-bottom {
        position: absolute;
        bottom: -22px;
        left: -20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(16, 185, 129, 0.25);
        padding: 12px 18px;
        border-radius: 18px;
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.12);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: floatBadgeReverse 4s ease-in-out infinite alternate;
        z-index: 10;
    }
    @keyframes floatBadge {
        0% { transform: translateY(0px); }
        100% { transform: translateY(-10px); }
    }
    @keyframes floatBadgeReverse {
        0% { transform: translateY(0px); }
        100% { transform: translateY(8px); }
    }
    .avatar-stack {
        display: flex;
        align-items: center;
    }
    .avatar-stack-item {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #fff;
        margin-left: -8px;
        object-fit: cover;
    }
    .avatar-stack-item:first-child {
        margin-left: 0;
    }
    /* Upgraded Stats Bar */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        padding: 28px 36px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(139, 92, 246, 0.16);
        border-radius: 24px;
        margin-bottom: 70px;
        box-shadow: 0 20px 40px -15px rgba(139, 92, 246, 0.12);
    }
    .stat-item {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .stat-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .stat-number {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-heading);
        line-height: 1.1;
    }
    .stat-label {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 600;
        margin-top: 2px;
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
    @media(max-width: 992px) {
        .hero-section { grid-template-columns: 1fr; gap: 40px; padding: 30px 0 50px; }
        .hero-title { font-size: 40px; }
        .hero-search-grid { grid-template-columns: 1fr 1fr; }
        .hero-search-btn { margin-top: 0; grid-column: span 2; justify-content: center; width: 100%; }
        .stats-bar { grid-template-columns: 1fr 1fr; gap: 20px; padding: 24px; }
        .contact-grid { grid-template-columns: 1fr; }
        .float-badge-top { top: 10px; right: 10px; }
        .float-badge-bottom { bottom: 10px; left: 10px; }
    }
    @media(max-width: 600px) {
        .hero-title { font-size: 32px; }
        .hero-subtitle { font-size: 15px; }
        .hero-search-grid { grid-template-columns: 1fr; }
        .hero-search-btn { grid-column: span 1; }
        .stats-bar { grid-template-columns: 1fr; gap: 16px; padding: 20px; }
    }
</style>
@endpush

@section('content')
<div class="home-container">
    <!-- 1. HERO SECTION -->
    <section class="hero-section" id="hero">
        <div>
            <div class="hero-badge-pill">
                <span class="hero-pulse-dot"></span>
                <span>Sri Lanka's #1 Event Marketplace</span>
                <span style="opacity: 0.5;">•</span>
                <span style="font-weight: 500;">1,200+ Celebrations Curated</span>
            </div>

            <h1 class="hero-title">
                Elevating Celebrations <span>Beyond Expectation.</span>
            </h1>

            <p class="hero-subtitle">
                Discover and book Sri Lanka's finest wedding florists, traditional Poruwa masters, concert DJ engineers, and luxury beachfront hotels — with upfront transparent LKR pricing and dedicated coordination.
            </p>

            <!-- Instant Discovery Search Bar Widget -->
            <div class="hero-search-box">
                <form action="{{ route('marketplace.index') }}" method="GET">
                    <div class="hero-search-grid">
                        <div class="hero-field-group">
                            <label class="hero-field-label" for="hero_event_type">
                                <i class="fas fa-sparkles" style="color: var(--primary);"></i> Occasion
                            </label>
                            <select id="hero_event_type" name="event_type" class="hero-field-select">
                                <option value="">All Occasions & Vibes</option>
                                @foreach($eventTypes as $et)
                                    <option value="{{ $et->event_type_id }}">{{ $et->type_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="hero-field-group">
                            <label class="hero-field-label" for="hero_location">
                                <i class="fas fa-map-marker-alt" style="color: #ec4899;"></i> Location
                            </label>
                            <select id="hero_location" name="location" class="hero-field-select">
                                <option value="">All Regions</option>
                                @foreach($popularLocations as $loc)
                                    <option value="{{ $loc }}">{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="hero-field-group">
                            <label class="hero-field-label" for="hero_date">
                                <i class="fas fa-calendar-alt" style="color: #f59e0b;"></i> Event Date
                            </label>
                            <input type="date" id="hero_date" name="date" class="hero-field-input" min="{{ date('Y-m-d') }}">
                        </div>

                        <div>
                            <button type="submit" class="hero-search-btn">
                                <i class="fas fa-search"></i>
                                <span>Find Vendors</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Quick Category Badges & Direct Links -->
            <div class="hero-quick-tags">
                <span style="font-weight: 700; color: var(--text-heading); font-size: 12px; text-transform: uppercase;">Trending:</span>
                <a href="{{ route('events.weddings') }}" class="hero-quick-pill">
                    <i class="fas fa-ring" style="color: #ec4899; font-size: 11px;"></i> Poruwa & Weddings
                </a>
                <a href="{{ route('events.dj-parties') }}" class="hero-quick-pill">
                    <i class="fas fa-headphones" style="color: #8b5cf6; font-size: 11px;"></i> DJ & Lighting
                </a>
                <a href="{{ route('food-calculator') }}" class="hero-quick-pill">
                    <i class="fas fa-calculator" style="color: #10b981; font-size: 11px;"></i> Food Budget Tool
                </a>
            </div>
        </div>

        <!-- Visual Collage Column with Floating Badges -->
        <div class="hero-showcase-wrap">
            <!-- Top Right Floating Social Proof Badge -->
            <div class="float-badge-top">
                <div class="avatar-stack">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=80&h=80&fit=crop" class="avatar-stack-item" alt="Client">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop" class="avatar-stack-item" alt="Client">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop" class="avatar-stack-item" alt="Client">
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: var(--text-heading); display: flex; align-items: center; gap: 4px;">
                        <i class="fas fa-star" style="color: #f59e0b; font-size: 12px;"></i> 4.9 / 5.0
                    </div>
                    <div style="font-size: 11px; color: var(--text-muted); font-weight: 600;">1,200+ Verified Reviews</div>
                </div>
            </div>

            <!-- Main High-Res Visual Showcase Card -->
            <div class="hero-main-card">
                <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=900&q=80&auto=format&fit=crop" alt="Sri Lankan Luxury Wedding Banquet" class="hero-main-img">
                <div class="hero-card-gradient"></div>
                <div class="hero-card-bottom">
                    <span class="hero-card-tag"><i class="fas fa-crown"></i> Featured Celebration</span>
                    <h3 style="font-size: 20px; font-weight: 800; line-height: 1.3; margin-bottom: 6px; color: #fff;">
                        Oceanfront Sunset Gala & Grand Poruwa
                    </h3>
                    <div style="display: flex; align-items: center; gap: 14px; font-size: 13px; opacity: 0.9;">
                        <span><i class="fas fa-map-pin" style="color: #f43f5e;"></i> Galle Fort, Sri Lanka</span>
                        <span>•</span>
                        <span><i class="fas fa-shield-check" style="color: #34d399;"></i> 100% Curated</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Left Floating Trust Badge -->
            <div class="float-badge-bottom">
                <div style="width: 38px; height: 38px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fas fa-shield-check"></i>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: var(--text-heading);">Verified Sri Lankan Vendors</div>
                    <div style="font-size: 11px; color: #059669; font-weight: 700;">Guaranteed Upfront LKR Pricing</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. PLATFORM METRICS -->
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-icon-wrap" style="background: rgba(139, 92, 246, 0.12); color: var(--primary);">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div class="stat-number">1,200+</div>
                <div class="stat-label">Celebrations Executed</div>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon-wrap" style="background: rgba(236, 72, 153, 0.12); color: #ec4899;">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <div class="stat-number">{{ $supplierCount > 0 ? $supplierCount : '450' }}+</div>
                <div class="stat-label">Certified Suppliers</div>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon-wrap" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                <i class="fas fa-tags"></i>
            </div>
            <div>
                <div class="stat-number">100%</div>
                <div class="stat-label">Transparent LKR Pricing</div>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon-wrap" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                <i class="fas fa-crown"></i>
            </div>
            <div>
                <div class="stat-number">4.9 ★</div>
                <div class="stat-label">Average Client Rating</div>
            </div>
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