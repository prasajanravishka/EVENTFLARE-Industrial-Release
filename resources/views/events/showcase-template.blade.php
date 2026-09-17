<style>
    /* Scoped Styles for Universal Showcase */
    .showcase-page {
        position: relative;
        overflow: hidden;
    }

    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.18;
        pointer-events: none;
        z-index: 0;
    }
    .orb-1 {
        width: 450px;
        height: 450px;
        background: {{ $config['theme_color'] ?? 'var(--primary)' }};
        top: -100px;
        left: -150px;
    }
    .orb-2 {
        width: 400px;
        height: 400px;
        background: var(--primary);
        top: 350px;
        right: -100px;
    }

    .showcase-hero {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 40px;
        align-items: center;
        margin-bottom: 70px;
        position: relative;
        z-index: 1;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: {{ $config['theme_gradient'] ?? 'rgba(139, 92, 246, 0.1)' }};
        color: {{ $config['theme_color'] ?? 'var(--primary)' }};
        border: 1px solid rgba(139, 92, 246, 0.25);
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .showcase-hero h1 {
        font-size: 44px;
        font-weight: 900;
        line-height: 1.18;
        color: var(--text-heading);
        margin-bottom: 16px;
    }

    .showcase-hero p.subtitle {
        color: var(--text-muted);
        font-size: 16px;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .hero-metrics-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 30px;
        box-shadow: var(--shadow-sm);
    }

    .hero-metric-item {
        display: flex;
        flex-direction: column;
    }

    .hero-metric-item .val {
        font-size: 22px;
        font-weight: 900;
        color: {{ $config['theme_color'] ?? 'var(--primary)' }};
        line-height: 1.1;
    }

    .hero-metric-item .lbl {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-top: 3px;
    }

    .hero-cta-buttons {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .hero-visual-card {
        height: 380px;
        border-radius: 24px;
        overflow: hidden;
        position: relative;
        box-shadow: var(--shadow-premium);
        border: 1px solid var(--card-border);
    }

    .hero-visual-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .hero-visual-card:hover img {
        transform: scale(1.04);
    }

    .hero-visual-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10, 8, 20, 0.88) 0%, rgba(10, 8, 20, 0.2) 60%, transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 28px;
        color: #fff;
    }

    /* Section Headings */
    .section-title-wrap {
        text-align: center;
        max-width: 680px;
        margin: 0 auto 35px;
    }

    .section-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: {{ $config['theme_color'] ?? 'var(--primary)' }};
        margin-bottom: 8px;
    }

    .section-title-wrap h2 {
        font-size: 32px;
        font-weight: 900;
        color: var(--text-heading);
        margin-bottom: 10px;
    }

    .section-title-wrap p {
        font-size: 15px;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }

    .filter-btn {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        color: var(--text-muted);
        padding: 9px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .filter-btn:hover {
        border-color: {{ $config['theme_color'] ?? 'var(--primary)' }};
        color: var(--text-heading);
    }

    .filter-btn.active {
        background: {{ $config['theme_color'] ?? 'var(--primary)' }};
        border-color: {{ $config['theme_color'] ?? 'var(--primary)' }};
        color: #fff;
        box-shadow: 0 4px 14px rgba(139, 92, 246, 0.3);
    }

    /* Case Studies Grid */
    .case-studies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 28px;
        margin-bottom: 70px;
    }

    .case-study-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .case-study-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-premium);
        border-color: rgba(139, 92, 246, 0.35);
    }

    .case-study-img-wrap {
        height: 220px;
        position: relative;
        overflow: hidden;
    }

    .case-study-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .case-cat-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(10, 8, 20, 0.75);
        backdrop-filter: blur(8px);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .case-guests-badge {
        position: absolute;
        bottom: 14px;
        right: 14px;
        background: rgba(10, 8, 20, 0.75);
        backdrop-filter: blur(8px);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .case-study-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .case-study-body h3 {
        font-size: 19px;
        font-weight: 800;
        color: var(--text-heading);
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .case-study-meta {
        display: flex;
        gap: 14px;
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .case-study-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .case-study-summary {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .case-study-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .case-study-actions .btn {
        flex: 1;
        padding: 9px 12px;
        font-size: 13px;
        font-weight: 700;
        border-radius: 10px;
        justify-content: center;
        white-space: nowrap;
    }

    /* Core Services Grid */
    .services-catalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
        gap: 24px;
        margin-bottom: 70px;
    }

    .service-pill-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 18px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-sm);
        transition: all 0.25s ease;
    }

    .service-pill-card:hover {
        transform: translateY(-4px);
        border-color: rgba(139, 92, 246, 0.35);
    }

    .service-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .service-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(139, 92, 246, 0.1);
        color: {{ $config['theme_color'] ?? 'var(--primary)' }};
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .badge-req {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .badge-req.mandatory {
        background: rgba(239, 68, 68, 0.12);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.25);
    }
    .badge-req.optional {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.25);
    }

    .service-pill-card h4 {
        font-size: 17px;
        font-weight: 800;
        color: var(--text-heading);
        margin-bottom: 8px;
    }

    .service-pill-card p {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.55;
        margin-bottom: 14px;
        flex-grow: 1;
    }

    .service-footer-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        color: var(--text-muted);
        border-top: 1px solid var(--card-border);
        padding-top: 12px;
    }

    /* Supplier Packages Grid */
    .packages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 70px;
    }

    .pkg-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .pkg-card:hover {
        transform: translateY(-5px);
        border-color: rgba(139, 92, 246, 0.35);
    }

    .pkg-img {
        height: 170px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .pkg-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .pkg-vendor {
        font-size: 11px;
        font-weight: 800;
        color: {{ $config['theme_color'] ?? 'var(--primary)' }};
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    .pkg-body h4 {
        font-size: 17px;
        font-weight: 800;
        color: var(--text-heading);
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .pkg-price-row {
        margin: 14px 0 18px;
        padding: 10px 14px;
        background: rgba(139, 92, 246, 0.06);
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .pkg-price {
        font-size: 19px;
        font-weight: 900;
        color: {{ $config['theme_color'] ?? 'var(--primary)' }};
    }

    .pkg-type {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: lowercase;
    }

    /* 4-Step Roadmap */
    .steps-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 70px;
    }

    .step-box {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 18px;
        padding: 24px 20px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        transition: all 0.25s ease;
        position: relative;
    }

    .step-box:hover {
        transform: translateY(-4px);
        border-color: rgba(139, 92, 246, 0.3);
    }

    .step-num {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: {{ $config['theme_color'] ?? 'var(--primary)' }};
        color: #fff;
        font-weight: 900;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }

    .step-box h4 {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-heading);
        margin-bottom: 8px;
    }

    .step-box p {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.55;
    }

    /* Catering Banner */
    .catering-banner {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(99, 102, 241, 0.14));
        border: 1px solid rgba(139, 92, 246, 0.25);
        border-radius: 20px;
        padding: 35px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 70px;
        backdrop-filter: blur(12px);
    }

    .catering-banner-text h3 {
        font-size: 23px;
        font-weight: 800;
        color: var(--text-heading);
        margin-bottom: 8px;
    }

    .catering-banner-text p {
        font-size: 14px;
        color: var(--text-muted);
        max-width: 600px;
        margin: 0;
        line-height: 1.6;
    }

    /* Testimonials Grid */
    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
        gap: 24px;
        margin-bottom: 70px;
    }

    .testimonial-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 18px;
        padding: 24px;
        box-shadow: var(--shadow-sm);
    }

    /* Bottom Final CTA */
    .final-cta-card {
        background: linear-gradient(135deg, #181133 0%, #2b1452 100%);
        border-radius: 24px;
        padding: 55px 35px;
        text-align: center;
        color: #fff;
        margin-bottom: 40px;
        border: 1px solid rgba(139, 92, 246, 0.3);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
    }

    .final-cta-card h2 {
        font-size: 36px;
        font-weight: 900;
        color: #fff;
        margin-bottom: 14px;
    }

    .final-cta-card p {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.85);
        max-width: 620px;
        margin: 0 auto 30px;
        line-height: 1.65;
    }

    .final-cta-buttons {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Dossier Modal */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(10, 8, 20, 0.75);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-backdrop.open {
        display: flex;
    }

    .modal-card {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 24px;
        max-width: 720px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
        position: relative;
        padding: 32px;
        animation: modalFadeIn 0.25s ease;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: rgba(0, 0, 0, 0.06);
        color: #333;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .modal-close-btn:hover {
        background: rgba(239, 68, 68, 0.12);
        color: #dc2626;
    }

    .modal-img {
        width: 100%;
        height: 240px;
        object-fit: cover;
        border-radius: 16px;
        margin-bottom: 20px;
    }

    .modal-services-list {
        margin: 20px 0;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
    }

    .modal-service-row {
        display: flex;
        justify-content: space-between;
        padding: 9px 0;
        border-bottom: 1px solid #e2e8f0;
        font-size: 13px;
    }
    .modal-service-row:last-child {
        border-bottom: none;
    }
    .modal-service-lbl {
        font-weight: 700;
        color: var(--text-heading);
    }
    .modal-service-val {
        color: var(--text-muted);
        text-align: right;
        max-width: 60%;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .showcase-hero {
            grid-template-columns: 1fr;
        }
        .hero-visual-card {
            height: 320px;
        }
        .steps-container {
            grid-template-columns: repeat(2, 1fr);
        }
        .catering-banner {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }
    }

    @media (max-width: 640px) {
        .showcase-hero h1 {
            font-size: 32px;
        }
        .hero-metrics-strip {
            grid-template-columns: repeat(2, 1fr);
        }
        .steps-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="showcase-page" style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    <!-- Background Glow Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <!-- 1. HERO SECTION -->
    <section class="showcase-hero">
        <div>
            <div class="hero-badge">
                {!! $config['hero_badge'] !!}
            </div>
            <h1>{!! $config['hero_title'] !!}</h1>
            <p class="subtitle">{{ $config['hero_subtitle'] }}</p>

            <!-- 4 Trust Proof Metrics -->
            <div class="hero-metrics-strip">
                @foreach($config['metrics'] as $m)
                    <div class="hero-metric-item">
                        <span class="val">{{ $m['val'] }}</span>
                        <span class="lbl">{{ $m['lbl'] }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Triple Action CTAs -->
            <div class="hero-cta-buttons">
                <a href="{{ route('booking.create', ['event' => $config['category_name']]) }}" class="btn btn-primary" style="padding: 12px 24px; font-weight: 800;">
                    <i class="fas fa-calendar-check"></i> Book This Category
                </a>
                <a href="#past-events" class="btn btn-secondary" style="padding: 12px 22px;">
                    <i class="fas fa-images"></i> View Executed Events
                </a>
                <a href="{{ route('food-calculator') }}" class="btn btn-secondary" style="padding: 12px 22px;">
                    <i class="fas fa-calculator"></i> Catering Estimator
                </a>
            </div>
        </div>

        <div>
            <div class="hero-visual-card">
                <img src="{{ asset($config['hero_image']) }}" alt="{{ $config['hero_card_title'] }}"
                     onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=800'">
                <div class="hero-visual-overlay">
                    <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #e9d5ff; font-weight: 800;">
                        {{ $config['hero_card_tag'] }}
                    </span>
                    <h3 style="font-size: 22px; font-weight: 900; margin: 4px 0 6px;">{{ $config['hero_card_title'] }}</h3>
                    <p style="font-size: 13px; color: rgba(255, 255, 255, 0.85); margin: 0;">{{ $config['hero_card_desc'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. FILTERABLE PREVIOUS EVENTS SHOWCASE -->
    <section id="past-events" style="margin-bottom: 70px;">
        <div class="section-title-wrap">
            <span class="section-tag">Authentic Portfolios</span>
            <h2>Executed {{ $config['category_name'] }} Showcase</h2>
            <p>Browse real events coordinated across Sri Lanka through EVENTFLARE. Filter by theme, view itemized vendor dossiers, and book similar setups directly.</p>
        </div>

        <!-- Filter Controls -->
        <div class="filter-tabs">
            @foreach($config['filter_tabs'] as $tab)
                <button type="button" class="filter-btn {{ $loop->first ? 'active' : '' }}" data-filter="{{ $tab['key'] }}">
                    {{ $tab['lbl'] }}
                </button>
            @endforeach
        </div>

        <!-- Case Studies Cards Grid -->
        <div class="case-studies-grid">
            @foreach($config['case_studies'] as $idx => $cs)
                <div class="case-study-card" data-category="{{ $cs['category'] }}">
                    <div class="case-study-img-wrap">
                        <img src="{{ asset($cs['image']) }}" alt="{{ $cs['title'] }}"
                             onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800'">
                        <div class="case-cat-badge">{{ $cs['category_lbl'] }}</div>
                        <div class="case-guests-badge">
                            <i class="fas fa-users"></i> {{ $cs['guests'] }} Guests
                        </div>
                    </div>

                    <div class="case-study-body">
                        <h3>{{ $cs['title'] }}</h3>
                        <div class="case-study-meta">
                            <span><i class="fas fa-map-marker-alt" style="color: {{ $config['theme_color'] ?? 'var(--primary)' }};"></i> {{ $cs['venue'] }}</span>
                            <span><i class="fas fa-calendar-alt" style="color: {{ $config['theme_color'] ?? 'var(--primary)' }};"></i> {{ $cs['date'] }}</span>
                        </div>
                        <p class="case-study-summary">{{ $cs['summary'] }}</p>

                        <div class="case-study-actions">
                            <button type="button" class="btn btn-secondary view-dossier-btn" data-index="{{ $idx }}">
                                <i class="fas fa-info-circle"></i> View Dossier
                            </button>
                            <a href="{{ route('booking.create', [
                                'event' => $config['category_name'],
                                'venue' => $cs['venue'],
                                'guests' => $cs['guests'],
                                'style' => $cs['category'],
                                'details' => 'Inspired by ' . $cs['title']
                            ]) }}" class="btn btn-primary">
                                <i class="fas fa-check"></i> Book Similar
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 3. CORE SERVICES CATALOG -->
    <section style="margin-bottom: 70px;">
        <div class="section-title-wrap">
            <span class="section-tag">Essential Pillars</span>
            <h2>Included Category Services</h2>
            <p>From core logistics to creative specialists, our platform connects you directly with accredited vendors for {{ $config['category_name'] }}.</p>
        </div>

        <div class="services-catalog-grid">
            @php
                $serviceIconMap = [
                    'Poruwa/Decorators'            => 'fa-archway',
                    'Ashtaka Narrator'             => 'fa-scroll',
                    'Jayamangala Gatha Choir'      => 'fa-microphone-alt',
                    'Kandyan Dancers and Drummers' => 'fa-drum',
                    'Catering'                     => 'fa-utensils',
                    'Photography & Videography'    => 'fa-camera-retro',
                    'Audio/Visual (A/V)'           => 'fa-bolt',
                    'DJs/Artists'                  => 'fa-music',
                    'Venue'                        => 'fa-map-marked-alt',
                    'Bar & Beverage Services'      => 'fa-cocktail',
                    'Security'                     => 'fa-shield-alt',
                    'Decorators'                   => 'fa-magic',
                    'Bakeries & Confectioners'     => 'fa-birthday-cake',
                    'Entertainment'                => 'fa-theater-masks',
                    'Elegant Halls/Banquet Spaces' => 'fa-hotel',
                    'In-House Catering'            => 'fa-concierge-bell',
                    'Guest Accommodations'         => 'fa-bed',
                    'Logistics & Parking'          => 'fa-car',
                    'Venue/Furniture Rentals'      => 'fa-chair',
                    'Light Entertainment'          => 'fa-guitar'
                ];
            @endphp

            @forelse($services as $srv)
                @php
                    $icon = $serviceIconMap[$srv->service_name] ?? 'fa-star';
                @endphp
                <div class="service-pill-card">
                    <div class="service-header-row">
                        <div class="service-icon-box">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <span class="badge-req {{ $srv->is_required ? 'mandatory' : 'optional' }}">
                            {{ $srv->is_required ? 'Core Pillar' : 'Optional Add-on' }}
                        </span>
                    </div>

                    <h4>{{ $srv->service_name }}</h4>
                    <p>{{ $srv->notes ?? $srv->description }}</p>

                    <div class="service-footer-info">
                        <span><i class="fas fa-users"></i> Up to {{ $srv->typical_capacity ?? 250 }} Guests</span>
                        <span style="font-weight: 700; color: {{ $config['theme_color'] ?? 'var(--primary)' }};">
                            Priority #{{ $srv->priority_rank }}
                        </span>
                    </div>
                </div>
            @empty
                <p style="text-align: center; grid-column: span 3; color: var(--text-muted);">
                    Services currently updating for this category.
                </p>
            @endforelse
        </div>
    </section>

    <!-- 4. ACTIVE SUPPLIER PACKAGES GRID -->
    @if(isset($packages) && $packages->isNotEmpty())
        <section style="margin-bottom: 70px;">
            <div class="section-title-wrap">
                <span class="section-tag">Direct Vendor Rates</span>
                <h2>Featured {{ $config['category_name'] }} Packages</h2>
                <p>Transparent pricing, transparent capacities, and instant booking handoff with verified suppliers.</p>
            </div>

            <div class="packages-grid">
                @foreach($packages as $pkg)
                    <div class="pkg-card">
                        <div class="pkg-img" style="background-image: url('{{ $pkg->image_url ? asset($pkg->image_url) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=500' }}');"></div>
                        <div class="pkg-body">
                            <div class="pkg-vendor">{{ $pkg->supplier->business_name }}</div>
                            <h4>{{ $pkg->title }}</h4>
                            <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 12px;">
                                {{ Str::limit($pkg->description, 95) }}
                            </p>

                            <div class="pkg-price-row">
                                <div>
                                    <span class="pkg-price">LKR {{ number_format($pkg->price) }}</span>
                                    <span class="pkg-type">/ {{ str_replace('_', ' ', $pkg->price_type) }}</span>
                                </div>
                                <div style="font-size: 12px; color: var(--text-muted);">
                                    <i class="fas fa-user-friends"></i> {{ $pkg->capacity ?? 200 }}
                                </div>
                            </div>

                            <a href="{{ route('booking.create', [
                                'event' => $config['category_name'],
                                'package' => $pkg->title,
                                'details' => 'Package: ' . $pkg->title . ' from ' . $pkg->supplier->business_name
                            ]) }}" class="btn btn-primary" style="margin-top: auto; width: 100%;">
                                <i class="fas fa-shopping-cart"></i> Book With Package
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- 5. 4-STEP PLANNING ROADMAP -->
    <section style="margin-bottom: 70px;">
        <div class="section-title-wrap">
            <span class="section-tag">Streamlined Flow</span>
            <h2>Plan in 4 Simple Steps</h2>
            <p>Our intelligent system coordinates everything from vendor selection to live budget tracking.</p>
        </div>

        <div class="steps-container">
            @foreach($config['steps'] as $step)
                <div class="step-box">
                    <div class="step-num">{{ $step['num'] }}</div>
                    <h4>{{ $step['title'] }}</h4>
                    <p>{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 6. CATERING CALCULATOR CALLOUT BANNER -->
    <section>
        <div class="catering-banner">
            <div class="catering-banner-text">
                <h3>Estimate Your Catering & Beverage Budget</h3>
                <p>Calculate your food expenditures across buffets, drinks, desserts, and snack platters with our live parametric cost calculator before completing your reservation.</p>
            </div>
            <div>
                <a href="{{ route('food-calculator') }}" class="btn btn-primary" style="white-space: nowrap; padding: 12px 24px; font-weight: 800;">
                    <i class="fas fa-calculator"></i> Launch Cost Calculator
                </a>
            </div>
        </div>
    </section>

    <!-- 7. CLIENT TESTIMONIALS -->
    <section style="margin-bottom: 70px;">
        <div class="section-title-wrap">
            <span class="section-tag">Client Voices</span>
            <h2>Words from Verified Hosts</h2>
        </div>

        <div class="testimonials-grid">
            @foreach($config['testimonials'] as $rev)
                <div class="testimonial-card">
                    <div style="color: #f59e0b; margin-bottom: 12px; font-size: 15px;">
                        @for($i = 0; $i < $rev['stars']; $i++) ★ @endfor
                    </div>
                    <p style="font-size: 13.5px; color: var(--text-main); font-style: italic; line-height: 1.65; margin-bottom: 15px;">
                        "{{ $rev['quote'] }}"
                    </p>
                    <div style="font-weight: 800; font-size: 14px; color: var(--text-heading);">— {{ $rev['name'] }}</div>
                    <div style="font-size: 12px; color: var(--text-muted);">{{ $rev['venue'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 8. BOTTOM FINAL CTA -->
    <section>
        <div class="final-cta-card">
            <h2>{{ $config['cta_title'] }}</h2>
            <p>{{ $config['cta_desc'] }}</p>
            <div class="final-cta-buttons">
                <a href="{{ route('booking.create', ['event' => $config['category_name']]) }}" class="btn btn-primary" style="background: #fff; color: var(--primary); font-weight: 800; padding: 13px 26px;">
                    <i class="fas fa-calendar-check"></i> Launch Booking Engine
                </a>
                <a href="{{ route('events.index') }}" class="btn btn-secondary" style="border-color: rgba(255,255,255,0.4); color: #fff; padding: 13px 24px;">
                    <i class="fas fa-th-large"></i> Explore Other Events
                </a>
                <a href="{{ route('about') }}" class="btn btn-secondary" style="border-color: rgba(255,255,255,0.4); color: #fff; padding: 13px 24px;">
                    <i class="fas fa-info-circle"></i> About EVENTFLARE
                </a>
            </div>
        </div>
    </section>
</div>

<!-- 9. INTERACTIVE CLIENT-SIDE DOSSIER MODAL -->
<div class="modal-backdrop" id="dossierModal">
    <div class="modal-card">
        <button type="button" class="modal-close-btn" id="closeModalBtn"><i class="fas fa-times"></i></button>
        <img src="" alt="Event Case Study" class="modal-img" id="modalImg">
        <div class="hero-badge" id="modalBadge" style="margin-bottom: 10px;"></div>
        <h2 id="modalTitle" style="font-size: 24px; font-weight: 900; margin-bottom: 8px; color: var(--text-heading);"></h2>
        <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
            <i class="fas fa-map-marker-alt" style="color: {{ $config['theme_color'] ?? 'var(--primary)' }};"></i> <span id="modalVenue"></span> &bull; 
            <i class="fas fa-users" style="color: {{ $config['theme_color'] ?? 'var(--primary)' }};"></i> <span id="modalGuests"></span> &bull;
            <i class="fas fa-calendar-alt" style="color: {{ $config['theme_color'] ?? 'var(--primary)' }};"></i> <span id="modalDate"></span>
        </div>
        <p id="modalSummary" style="font-size: 14px; color: var(--text-main); line-height: 1.65; margin-bottom: 20px;"></p>
        
        <h4 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 8px;">
            <i class="fas fa-clipboard-list" style="color: {{ $config['theme_color'] ?? 'var(--primary)' }}; margin-right: 6px;"></i> Itemized Supplier & Production Breakdown:
        </h4>
        <div class="modal-services-list" id="modalServicesList"></div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 25px;">
            <button type="button" class="btn btn-secondary" id="modalCloseAction">Close</button>
            <a href="#" class="btn btn-primary" id="modalBookBtn" style="font-weight: 800;">
                <i class="fas fa-check"></i> Book With This Style
            </a>
        </div>
    </div>
</div>

<!-- JavaScript Controllers -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const caseStudiesData = @json($config['case_studies']);
        const bookingBaseUrl = "{{ route('booking.create') }}";
        const currentCategory = "{{ $config['category_name'] }}";

        // 1. Filter Tabs Logic
        const filterBtns = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.case-study-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.getAttribute('data-filter');
                cards.forEach(card => {
                    const cardCat = card.getAttribute('data-category');
                    if (filter === 'all' || cardCat === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // 2. Dossier Modal Logic
        const modal = document.getElementById('dossierModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalCloseAction = document.getElementById('modalCloseAction');
        const viewButtons = document.querySelectorAll('.view-dossier-btn');

        viewButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const idx = parseInt(btn.getAttribute('data-index'));
                const data = caseStudiesData[idx];
                if (!data) return;

                const modalImg = document.getElementById('modalImg');
                modalImg.src = "{{ asset('') }}" + data.image;
                modalImg.onerror = function() {
                    this.src = 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800';
                };

                document.getElementById('modalBadge').textContent = data.category_lbl;
                document.getElementById('modalTitle').textContent = data.title;
                document.getElementById('modalVenue').textContent = data.venue;
                document.getElementById('modalGuests').textContent = data.guests + ' Guests';
                document.getElementById('modalDate').textContent = data.date;
                document.getElementById('modalSummary').textContent = data.summary;

                const servicesContainer = document.getElementById('modalServicesList');
                servicesContainer.innerHTML = '';
                if (data.services) {
                    for (const [key, val] of Object.entries(data.services)) {
                        const row = document.createElement('div');
                        row.className = 'modal-service-row';
                        row.innerHTML = `<span class="modal-service-lbl">${key}</span><span class="modal-service-val">${val}</span>`;
                        servicesContainer.appendChild(row);
                    }
                }

                // Construct Deep-Link URL
                const targetUrl = new URL(bookingBaseUrl, window.location.origin);
                targetUrl.searchParams.set('event', currentCategory);
                targetUrl.searchParams.set('venue', data.venue);
                targetUrl.searchParams.set('guests', data.guests);
                targetUrl.searchParams.set('style', data.category);
                targetUrl.searchParams.set('details', 'Inspired by ' + data.title);

                const bookBtn = document.getElementById('modalBookBtn');
                bookBtn.href = targetUrl.toString();

                modal.classList.add('open');
            });
        });

        function closeModal() {
            modal.classList.remove('open');
        }

        closeModalBtn.addEventListener('click', closeModal);
        modalCloseAction.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('open')) {
                closeModal();
            }
        });
    });
</script>
