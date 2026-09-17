@extends('layouts.eventflare')

@section('title', 'Core Celebration Sectors — EVENTFLARE')

@push('styles')
<style>
    /* Full-Width Base Container */
    .events-hub-wrapper {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    /* Ambient Glowing Radiant Orbs */
    .events-hero-wrap {
        width: 100%;
        background: linear-gradient(135deg, #fbfaff 0%, #f4f0ff 40%, #fdf2f8 75%, #fffbeb 100%);
        border-bottom: 1px solid rgba(139, 92, 246, 0.12);
        position: relative;
        padding: 65px 36px 55px 36px;
        box-sizing: border-box;
        overflow: hidden;
        text-align: center;
    }
    .events-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.5;
        pointer-events: none;
    }
    .events-orb-1 {
        width: 480px;
        height: 480px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.28) 0%, rgba(139, 92, 246, 0) 70%);
        top: -140px;
        left: 4%;
    }
    .events-orb-2 {
        width: 440px;
        height: 440px;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.22) 0%, rgba(236, 72, 153, 0) 70%);
        bottom: -120px;
        right: 4%;
    }

    /* Hero Live Badge Pill */
    .events-live-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        color: #4b5563;
        padding: 9px 24px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid rgba(139, 92, 246, 0.2);
        margin-bottom: 22px;
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.12);
    }
    .pulse-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.8);
        animation: pulseGreenGlow 2s infinite;
    }
    @keyframes pulseGreenGlow {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.1); }
    }

    /* Headline & Subtitle */
    .events-title {
        font-size: 48px;
        font-weight: 900;
        color: #111827;
        line-height: 1.15;
        letter-spacing: -0.025em;
        margin-bottom: 16px;
    }
    .events-title span {
        background: linear-gradient(135deg, #7c3aed 0%, #db2777 50%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .events-subtitle {
        font-size: 17px;
        color: #4b5563;
        line-height: 1.7;
        max-width: 800px;
        margin: 0 auto 30px auto;
    }

    /* Key Trust Metrics Strip */
    .events-metrics-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        max-width: 920px;
        margin: 0 auto 32px auto;
        padding: 18px 24px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(139, 92, 246, 0.16);
        border-radius: 20px;
        box-shadow: 0 12px 32px -8px rgba(139, 92, 246, 0.12);
    }
    .events-metric-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .events-metric-val {
        font-size: 24px;
        font-weight: 900;
        background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.2;
    }
    .events-metric-lbl {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 4px;
    }

    /* Interactive Filter Tabs & Real-time Search */
    .events-controls-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .events-search-box {
        position: relative;
        width: 100%;
    }
    .events-search-box i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 18px;
    }
    .events-search-input {
        width: 100%;
        padding: 15px 20px 15px 54px;
        border-radius: 50px;
        border: 1px solid rgba(139, 92, 246, 0.25);
        background: #ffffff;
        font-size: 15px;
        color: #1f2937;
        box-shadow: 0 6px 24px rgba(139, 92, 246, 0.08);
        transition: all 0.25s ease;
        box-sizing: border-box;
    }
    .events-search-input:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 8px 30px rgba(139, 92, 246, 0.18);
    }
    .events-tabs-list {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .events-tab-pill {
        padding: 9px 20px;
        border-radius: 40px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid rgba(139, 92, 246, 0.18);
        background: #ffffff;
        color: #4b5563;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .events-tab-pill:hover {
        background: rgba(139, 92, 246, 0.08);
        color: #6d28d9;
        border-color: #8b5cf6;
    }
    .events-tab-pill.active {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 6px 18px rgba(109, 40, 217, 0.3);
    }

    /* Content Sections Layout */
    .events-section-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 60px 24px 80px 24px;
        box-sizing: border-box;
    }
    .events-section-header {
        text-align: center;
        max-width: 740px;
        margin: 0 auto 45px auto;
    }
    .events-section-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(139, 92, 246, 0.1);
        color: #7c3aed;
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 14px;
    }
    .events-section-title {
        font-size: 36px;
        font-weight: 900;
        color: #111827;
        letter-spacing: -0.02em;
        margin-bottom: 12px;
    }
    .events-section-desc {
        color: #64748b;
        font-size: 16px;
        line-height: 1.6;
    }

    /* Category Portfolio Grid */
    .category-portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
        gap: 30px;
    }
    .category-hub-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 8px 26px -6px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }
    .category-hub-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px -10px rgba(139, 92, 246, 0.16);
        border-color: rgba(139, 92, 246, 0.25);
    }
    .category-media-header {
        height: 220px;
        position: relative;
        overflow: hidden;
    }
    .category-media-header img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .category-hub-card:hover .category-media-header img {
        transform: scale(1.06);
    }
    .category-media-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.2) 60%, transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 18px 20px;
    }
    .category-badge-chip {
        align-self: flex-start;
        background: rgba(255, 255, 255, 0.95);
        color: #1e293b;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .category-media-title-wrap {
        color: #ffffff;
    }
    .category-media-title-wrap h3 {
        font-size: 22px;
        font-weight: 800;
        margin: 0 0 4px 0;
        color: #ffffff;
    }
    .category-media-title-wrap p {
        margin: 0;
        font-size: 13px;
        color: #e2e8f0;
        opacity: 0.9;
    }
    .category-card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .category-summary-text {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    .category-services-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 0.05em;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .category-services-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-bottom: 24px;
    }
    .service-mini-tag {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    .category-card-footer {
        padding: 16px 24px 22px 24px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: 12px;
        background: #fafafa;
    }
    .btn-showcase-view {
        flex: 1;
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 11px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-showcase-view:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
    }
    .btn-book-direct {
        flex: 1;
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        color: #ffffff;
        border: none;
        padding: 11px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.25);
        transition: all 0.2s ease;
    }
    .btn-book-direct:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(109, 40, 217, 0.35);
        color: #ffffff;
    }

    /* Responsive Queries */
    @media (max-width: 900px) {
        .events-title { font-size: 38px; }
        .events-metrics-bar { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .events-hero-wrap { padding: 50px 20px; }
        .events-title { font-size: 30px; }
        .events-metrics-bar { grid-template-columns: 1fr; }
        .category-portfolio-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="events-hub-wrapper">

    <!-- 1. Ambient Radiant Hero -->
    <section class="events-hero-wrap">
        <div class="events-orb events-orb-1"></div>
        <div class="events-orb events-orb-2"></div>

        <div style="position: relative; z-index: 2; max-width: 1100px; margin: 0 auto;">
            <!-- Live Pulse Pill -->
            <div class="events-live-badge">
                <span class="pulse-indicator"></span>
                <span>Core Celebration Sectors &bull; Master Portfolio</span>
            </div>

            <!-- Main Headline -->
            <h1 class="events-title">
                Choose Your <span>Event Category</span>
            </h1>

            <p class="events-subtitle">
                Select an event type below to browse accredited vendor packages, itemized services, and customize your celebration across Sri Lanka.
            </p>

            <!-- Metrics Strip -->
            <div class="events-metrics-bar">
                <div class="events-metric-box">
                    <span class="events-metric-val">{{ $metrics['categories_count'] ?? 5 }}</span>
                    <span class="events-metric-lbl">Core Sectors</span>
                </div>
                <div class="events-metric-box">
                    <span class="events-metric-val">150+</span>
                    <span class="events-metric-lbl">Events Planned</span>
                </div>
                <div class="events-metric-box">
                    <span class="events-metric-val">{{ $metrics['suppliers_count'] ?? '50+' }}</span>
                    <span class="events-metric-lbl">Verified Vendors</span>
                </div>
                <div class="events-metric-box">
                    <span class="events-metric-val">{{ $metrics['avg_rating'] ?? '4.9 ★' }}</span>
                    <span class="events-metric-lbl">Client Rating</span>
                </div>
            </div>

            <!-- Search & Filter Controls -->
            <div class="events-controls-wrapper">
                <div class="events-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="eventSearchInput" class="events-search-input" placeholder="Search celebrations, services (e.g. Poruwa, DJ Sound, Fondant Cake, 5-Star Hall)...">
                </div>

                <div class="events-tabs-list" id="categoryTabsList">
                    <button type="button" class="events-tab-pill active" data-category="all">
                        <i class="fas fa-th-large"></i> All Sectors
                    </button>
                    <button type="button" class="events-tab-pill" data-category="weddings">
                        <i class="fas fa-gem"></i> Royal Weddings
                    </button>
                    <button type="button" class="events-tab-pill" data-category="dj-parties">
                        <i class="fas fa-compact-disc"></i> DJ Parties & Sound
                    </button>
                    <button type="button" class="events-tab-pill" data-category="birthdays">
                        <i class="fas fa-birthday-cake"></i> Birthdays & Themes
                    </button>
                    <button type="button" class="events-tab-pill" data-category="hotel-venues">
                        <i class="fas fa-hotel"></i> 5-Star Venues
                    </button>
                    <button type="button" class="events-tab-pill" data-category="get-together">
                        <i class="fas fa-users"></i> Reunions & BBQs
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Master Category Pillars Grid: Core Celebration Sectors -->
    <section class="events-section-container" id="categoriesSection">
        <div class="events-section-header">
            <span class="events-section-badge"><i class="fas fa-layer-group"></i> Core Celebration Sectors</span>
            <h2 class="events-section-title">Choose Your Event Category</h2>
            <p class="events-section-desc">Each category offers vetted vendors, transparent pricing, and customizable services tailored for Sri Lankan hospitality traditions.</p>
        </div>

        <div class="category-portfolio-grid" id="categoryCardsGrid">
            @foreach($eventTypes as $type)
                @php
                    $meta = $categoryMeta[$type->type_name] ?? [
                        'slug' => 'weddings',
                        'route' => 'events.weddings',
                        'booking_param' => $type->type_name,
                        'image' => 'assets/images/weding.jpg',
                        'badge' => 'Celebration',
                        'tagline' => $type->description,
                        'color' => '#8b5cf6',
                        'accent_gradient' => 'linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%)'
                    ];
                    $serviceList = $type->services->take(6);
                @endphp
                <div class="category-hub-card event-filterable-item" data-category="{{ $meta['slug'] }}" data-keywords="{{ strtolower($type->type_name . ' ' . $type->description . ' ' . $type->services->pluck('service_name')->join(' ')) }}">
                    <div class="category-media-header">
                        <img src="{{ asset($meta['image']) }}" alt="{{ $type->type_name }}" onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=600'">
                        <div class="category-media-overlay">
                            <span class="category-badge-chip">{{ $meta['badge'] }}</span>
                            <div class="category-media-title-wrap">
                                <h3>{{ $type->type_name }}</h3>
                                <p>{{ $meta['tagline'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="category-card-body">
                        <p class="category-summary-text">{{ $type->description }}</p>

                        <div class="category-services-label">
                            <i class="fas fa-check-circle" style="color: #10b981;"></i> Accredited Services Included:
                        </div>
                        <div class="category-services-tags">
                            @foreach($serviceList as $service)
                                <span class="service-mini-tag">{{ $service->service_name }}</span>
                            @endforeach
                            @if($type->services->count() > 6)
                                <span class="service-mini-tag" style="background: rgba(139, 92, 246, 0.1); color: #7c3aed; font-weight: 800;">+{{ $type->services->count() - 6 }} more</span>
                            @endif
                        </div>
                    </div>

                    <div class="category-card-footer">
                        <a href="{{ route($meta['route']) }}" class="btn-showcase-view">
                            <i class="fas fa-eye"></i> View Showcase
                        </a>
                        <a href="{{ route('booking.create', ['event' => $meta['booking_param']]) }}" class="btn-book-direct">
                            <i class="fas fa-calendar-check"></i> Book Event
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State Fallback -->
        <div id="noEventsFallback" style="display: none; text-align: center; padding: 60px 20px;">
            <div style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"><i class="fas fa-search"></i></div>
            <h4 style="font-size: 20px; font-weight: 800; color: #334155; margin-bottom: 8px;">No matching categories found</h4>
            <p style="color: #64748b; font-size: 15px; margin-bottom: 20px;">Try adjusting your keyword or reset to view all categories.</p>
            <button type="button" onclick="resetEventFilters()" class="btn-showcase-view" style="display: inline-flex; max-width: 180px; margin: 0 auto;">Reset Filters</button>
        </div>
    </section>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('eventSearchInput');
        const tabButtons = document.querySelectorAll('.events-tab-pill');
        const filterableItems = document.querySelectorAll('.event-filterable-item');
        const fallbackNotice = document.getElementById('noEventsFallback');

        let currentCategory = 'all';
        let searchQuery = '';

        function applyFilters() {
            let visibleCount = 0;

            filterableItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                const itemKeywords = item.getAttribute('data-keywords') || '';

                const matchesCategory = (currentCategory === 'all' || itemCategory === currentCategory);
                const matchesSearch = (!searchQuery || itemKeywords.includes(searchQuery));

                if (matchesCategory && matchesSearch) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (fallbackNotice) {
                fallbackNotice.style.display = (visibleCount === 0) ? 'block' : 'none';
            }
        }

        // Tab selection logic
        tabButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                tabButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentCategory = this.getAttribute('data-category') || 'all';
                applyFilters();
            });
        });

        // Instant search input logic
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                searchQuery = this.value.trim().toLowerCase();
                applyFilters();
            });
        }

        // Global reset filter trigger
        window.resetEventFilters = function () {
            if (searchInput) searchInput.value = '';
            searchQuery = '';
            currentCategory = 'all';
            tabButtons.forEach(b => b.classList.remove('active'));
            const allBtn = document.querySelector('.events-tab-pill[data-category="all"]');
            if (allBtn) allBtn.classList.add('active');
            applyFilters();
        };
    });
</script>
@endpush
@endsection