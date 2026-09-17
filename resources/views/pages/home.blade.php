@extends('layouts.eventflare')

@section('title', 'EVENTFLARE — Curated Event Planning & Marketplace')

@push('styles')
<style>
    /* Full-Width Base Wrapper */
    .home-wrapper {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* 100% Edge-to-Edge Full Width Hero */
    .cinematic-hero-wrap {
        width: 100%;
        background: linear-gradient(135deg, #fbfaff 0%, #f4f0ff 40%, #fdf2f8 75%, #fffbeb 100%);
        border-bottom: 1px solid rgba(139, 92, 246, 0.12);
        overflow: hidden;
        margin: 0;
        padding: 85px 40px 75px 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        box-sizing: border-box;
    }

    /* Ambient Radiant Blurred Orbs */
    .hero-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.55;
        pointer-events: none;
    }
    .hero-orb-1 {
        width: 520px;
        height: 520px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.28) 0%, rgba(139, 92, 246, 0) 70%);
        top: -120px;
        left: 6%;
    }
    .hero-orb-2 {
        width: 480px;
        height: 480px;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.22) 0%, rgba(236, 72, 153, 0) 70%);
        bottom: -100px;
        right: 6%;
    }
    .cinematic-hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
    }

    /* Live Status Badge Pill (Clean Light Mode) */
    .hero-live-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        color: #4b5563;
        padding: 9px 22px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid rgba(139, 92, 246, 0.18);
        margin-bottom: 26px;
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

    /* Bright High-Contrast Headline & Subtitle */
    .cinematic-title {
        font-size: 58px;
        font-weight: 900;
        color: #111827;
        line-height: 1.15;
        letter-spacing: -0.025em;
        margin-bottom: 20px;
    }
    .cinematic-title span {
        background: linear-gradient(135deg, #7c3aed 0%, #db2777 50%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .cinematic-sub {
        font-size: 18px;
        color: #4b5563;
        line-height: 1.7;
        max-width: 840px;
        margin: 0 auto 36px auto;
        font-weight: 450;
    }

    /* High-Converting Dual Action Buttons */
    .hero-cta-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
        flex-wrap: wrap;
        margin-bottom: 36px;
    }
    .hero-btn-primary {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        color: #ffffff;
        padding: 16px 38px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.35);
        transition: all 0.25s ease;
    }
    .hero-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(139, 92, 246, 0.45);
        color: #ffffff;
    }
    .hero-btn-secondary {
        background: #ffffff;
        color: #1f2937;
        padding: 16px 36px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        transition: all 0.25s ease;
    }
    .hero-btn-secondary:hover {
        transform: translateY(-2px);
        color: var(--primary);
        border-color: rgba(139, 92, 246, 0.3);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    /* Trust Proof Micro-Features (Light Mode) */
    .hero-trust-features {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 32px;
        flex-wrap: wrap;
        padding-top: 6px;
    }
    .hero-trust-item {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: #4b5563;
        font-size: 14px;
        font-weight: 600;
    }
    .hero-trust-item i {
        font-size: 16px;
    }

    /* Modern 4-Pillar Trust Metrics Bar (Embedded in Hero, Edge-to-Edge Fluid) */
    .cinematic-stats-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        padding: 26px 36px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(139, 92, 246, 0.16);
        border-radius: 24px;
        margin-top: 48px;
        margin-bottom: 0;
        box-shadow: 0 16px 36px -10px rgba(139, 92, 246, 0.14);
        width: 100%;
        box-sizing: border-box;
    }
    .cinematic-stat-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 6px 14px;
    }
    .cinematic-stat-item:not(:last-child) {
        border-right: 1px solid #f1f5f9;
    }
    .cinematic-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .cinematic-stat-num {
        font-size: 26px;
        font-weight: 800;
        color: var(--text-heading);
        line-height: 1.15;
    }
    .cinematic-stat-label {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 600;
        margin-top: 2px;
    }

    /* Full Width Content Wrapper Below Hero */
    .home-content-wrap {
        width: 100%;
        max-width: 100%;
        padding: 50px 40px 80px 40px;
        box-sizing: border-box;
    }

    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(139, 92, 246, 0.08);
        color: var(--primary);
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 12px;
        border: 1px solid rgba(139, 92, 246, 0.15);
    }

    /* Event Category UX: Interactive Filter Pills */
    .category-filter-pills {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 36px;
    }
    .cat-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #4b5563;
        padding: 9px 20px;
        border-radius: 50px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .cat-pill:hover {
        background: #f8fafc;
        border-color: rgba(139, 92, 246, 0.4);
        color: var(--primary);
        transform: translateY(-2px);
    }
    .cat-pill.active {
        background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 6px 18px rgba(124, 58, 237, 0.35);
    }

    /* Event Showcase Grid & Rich Cards (Enhanced UX 3x2 Grid) */
    .event-showcase-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
        width: 100%;
        box-sizing: border-box;
    }
    .event-showcase-card {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        box-sizing: border-box;
    }
    .event-showcase-card:hover {
        transform: translateY(-6px);
        border-color: rgba(139, 92, 246, 0.35);
        box-shadow: 0 20px 40px rgba(139, 92, 246, 0.14);
    }
    .event-card-img-wrap {
        height: 195px;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 18px;
        position: relative;
        background: #f1f5f9;
    }
    .event-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .event-showcase-card:hover .event-card-img {
        transform: scale(1.05);
    }
    .event-rating-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #ffffff;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    .event-badge-tag {
        position: absolute;
        top: 12px;
        right: 12px;
        color: #ffffff;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .event-card-title {
        font-size: 21px;
        font-weight: 800;
        color: var(--text-heading);
        margin-bottom: 8px;
        line-height: 1.25;
    }
    .event-card-desc {
        color: var(--text-muted);
        font-size: 13.5px;
        line-height: 1.6;
        margin-bottom: 16px;
    }
    .event-card-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 18px;
    }
    .event-chip {
        font-size: 11.5px;
        font-weight: 600;
        color: #4b5563;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 4px 10px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .event-card-meta-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        margin-bottom: 18px;
        border-top: 1px solid #f1f5f9;
        font-size: 12.5px;
        font-weight: 700;
    }
    .meta-price {
        color: var(--text-heading);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .meta-vendors {
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .event-card-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }
    .event-btn-outline {
        flex: 1;
        text-align: center;
        padding: 11px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        color: #6366f1;
        background: #ffffff;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .event-btn-outline:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #4f46e5;
    }
    .event-btn-primary {
        flex: 1;
        text-align: center;
        padding: 11px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
        color: #ffffff;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.28);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .event-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(99, 102, 241, 0.4);
        color: #ffffff;
    }

    /* Helpful Concierge Assistance Strip */
    .category-concierge-strip {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 22px 30px;
        margin-bottom: 80px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        box-shadow: var(--shadow-premium);
        box-sizing: border-box;
    }
    .concierge-strip-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .concierge-strip-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(139, 92, 246, 0.12);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .btn-concierge-sec {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1f2937;
        font-size: 13px;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-concierge-sec:hover {
        background: #f9fafb;
        color: var(--primary);
        border-color: rgba(139, 92, 246, 0.4);
    }
    .btn-concierge-prim {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        padding: 10px 22px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 14px rgba(139, 92, 246, 0.28);
        transition: all 0.2s ease;
    }
    .btn-concierge-prim:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(139, 92, 246, 0.38);
        color: #ffffff;
    }

    /* Full-Width Reviews Grid */
    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 80px;
        width: 100%;
        box-sizing: border-box;
    }
    .review-card {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 26px;
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

    /* Full Width Mission & Contact */
    .about-card {
        background: rgba(139, 92, 246, 0.04);
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 56px 40px;
        margin-bottom: 80px;
        width: 100%;
        box-sizing: border-box;
    }

    /* ============================================================
       ABOUT US: STORY, VISION & MISSION SECTION (LUXURY LIGHT UX)
       ============================================================ */
    .about-story-section {
        width: 100%;
        margin-bottom: 80px;
        box-sizing: border-box;
    }
    .about-header-wrap {
        text-align: center;
        max-width: 860px;
        margin: 0 auto 48px auto;
    }
    .about-main-title {
        font-size: 38px;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--text-main);
        margin: 14px 0 14px 0;
        line-height: 1.25;
    }
    .about-main-subtitle {
        color: var(--text-muted);
        font-size: 16.5px;
        line-height: 1.7;
        margin: 0 auto;
    }
    .about-story-grid {
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        gap: 36px;
        align-items: stretch;
        margin-bottom: 36px;
    }

    /* Left Column: Our Story Showcase Card */
    .story-showcase-card {
        background: #ffffff;
        border: 1px solid rgba(139, 92, 246, 0.14);
        border-radius: 28px;
        padding: 36px;
        box-shadow: 0 20px 45px -15px rgba(139, 92, 246, 0.07);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .story-showcase-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }
    .story-content-body {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .story-tag-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 14px;
        background: rgba(139, 92, 246, 0.1);
        color: var(--primary);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        border-radius: 999px;
        width: fit-content;
    }
    .story-title {
        font-size: 26px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.3;
        margin: 0;
    }
    .story-text {
        font-size: 14.5px;
        line-height: 1.75;
        color: var(--text-muted);
        margin: 0;
    }
    .story-quote-box {
        background: rgba(248, 250, 252, 0.85);
        border-left: 3px solid var(--primary);
        border-radius: 0 14px 14px 0;
        padding: 16px 20px;
        margin-top: 6px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }
    .story-quote-icon {
        color: var(--primary);
        font-size: 20px;
        line-height: 1;
        opacity: 0.8;
        margin-top: 2px;
    }
    .story-quote-body {
        font-size: 13.5px;
        font-style: italic;
        color: #334155;
        line-height: 1.6;
    }
    .story-quote-author {
        font-size: 12px;
        font-style: normal;
        font-weight: 700;
        color: var(--text-muted);
        margin-top: 6px;
    }
    .story-actions {
        display: flex;
        gap: 14px;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 22px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    /* Right Column: Vision & Mission Cards */
    .vision-mission-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
        justify-content: space-between;
    }
    .vm-card {
        border-radius: 26px;
        padding: 32px;
        box-shadow: var(--shadow-premium);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 16px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .vm-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 22px 45px -15px rgba(0, 0, 0, 0.08);
    }
    .vision-card {
        border: 1px solid rgba(139, 92, 246, 0.18);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 245, 255, 0.95) 100%);
    }
    .mission-card {
        border: 1px solid rgba(16, 185, 129, 0.2);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(240, 253, 248, 0.95) 100%);
    }
    .vm-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }
    .vm-icon-bubble {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .vision-bubble {
        background: rgba(139, 92, 246, 0.12);
        color: var(--primary);
    }
    .mission-bubble {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
    }
    .vm-badge-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 5px 12px;
        border-radius: 999px;
    }
    .vision-label {
        background: rgba(139, 92, 246, 0.1);
        color: var(--primary);
    }
    .mission-label {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
    }
    .vm-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.35;
        margin: 0;
    }
    .vm-body {
        font-size: 14px;
        line-height: 1.7;
        color: var(--text-muted);
        margin: 0;
    }
    .vm-bullet-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 4px;
    }
    .vm-bullet-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13.5px;
        color: #334155;
        line-height: 1.5;
    }
    .vm-bullet-item i {
        font-size: 14px;
        margin-top: 3px;
        flex-shrink: 0;
        color: var(--primary);
    }
    .vm-pillar-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 6px;
    }
    .vm-pillar-item {
        background: #ffffff;
        border: 1px solid rgba(16, 185, 129, 0.18);
        border-radius: 14px;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .vm-pillar-item i {
        font-size: 16px;
        color: #059669;
        margin-bottom: 2px;
    }
    .vm-pillar-name {
        font-size: 12px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.2;
    }
    .vm-pillar-desc {
        font-size: 11px;
        color: var(--text-muted);
        line-height: 1.35;
    }
    .mission-partner-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-top: 14px;
        margin-top: 4px;
        border-top: 1px dashed rgba(16, 185, 129, 0.25);
    }
    .mission-partner-text {
        font-size: 13px;
        color: #475569;
        font-weight: 600;
    }

    /* Island-Wide Milestone Footprint Ribbon */
    .about-milestone-ribbon {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 28px 36px;
        box-shadow: var(--shadow-premium);
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        align-items: center;
    }
    .milestone-box {
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
    }
    .milestone-box:not(:last-child)::after {
        content: '';
        position: absolute;
        right: -12px;
        top: 15%;
        bottom: 15%;
        width: 1px;
        background: #e2e8f0;
    }
    .milestone-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(139, 92, 246, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--primary);
        flex-shrink: 0;
    }
    .milestone-content {
        display: flex;
        flex-direction: column;
    }
    .milestone-number {
        font-size: 24px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.2;
    }
    .milestone-desc {
        font-size: 12.5px;
        color: var(--text-muted);
        margin-top: 3px;
        font-weight: 500;
        line-height: 1.4;
    }

    .contact-wrapper {
        background: #ffffff;
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 50px 40px;
        margin-bottom: 80px;
        box-shadow: var(--shadow-premium);
        width: 100%;
        box-sizing: border-box;
    }
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 50px;
        width: 100%;
    }

    /* Responsive Breakpoints */
    @media(max-width: 1024px) {
        .event-showcase-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
    }
    @media(max-width: 992px) {
        .cinematic-hero-wrap { padding: 65px 20px 55px 20px; }
        .home-content-wrap { padding: 30px 20px 60px 20px; }
        .cinematic-title { font-size: 42px; }
        .cinematic-sub { font-size: 16px; margin-bottom: 30px; }
        .hero-cta-group { gap: 14px; }
        .hero-btn-primary, .hero-btn-secondary { width: 100%; max-width: 320px; justify-content: center; padding: 14px 28px; }
        .hero-trust-features { gap: 20px; }
        .cinematic-stats-bar { grid-template-columns: 1fr 1fr; gap: 18px; padding: 20px; }
        .cinematic-stat-item:not(:last-child) { border-right: none; }
        .reviews-grid { grid-template-columns: repeat(2, 1fr); }
        .contact-grid { grid-template-columns: 1fr; }
        .about-story-grid { grid-template-columns: 1fr; gap: 28px; }
        .about-milestone-ribbon { grid-template-columns: repeat(2, 1fr); gap: 24px; padding: 24px; }
        .milestone-box:not(:last-child)::after { display: none; }
        .about-main-title { font-size: 30px; }
    }
    @media(max-width: 680px) {
        .event-showcase-grid { grid-template-columns: 1fr; gap: 20px; }
    }
    @media(max-width: 600px) {
        .cinematic-hero-wrap { padding: 50px 16px 45px 16px; }
        .home-content-wrap { padding: 24px 16px 50px 16px; }
        .cinematic-title { font-size: 32px; }
        .cinematic-sub { font-size: 15px; }
        .hero-live-badge { font-size: 12px; padding: 7px 16px; }
        .hero-trust-features { flex-direction: column; gap: 12px; }
        .cinematic-stats-bar { grid-template-columns: 1fr; gap: 14px; padding: 18px; }
        .reviews-grid { grid-template-columns: 1fr; }
        .about-milestone-ribbon { grid-template-columns: 1fr; gap: 18px; padding: 20px 16px; }
        .vm-pillar-grid { grid-template-columns: 1fr; gap: 10px; }
        .story-showcase-card { padding: 24px 18px; }
        .vm-card { padding: 24px 18px; }
        .mission-partner-footer { flex-direction: column; align-items: flex-start; gap: 10px; }
    }

    /* Real Executed Events / Case Studies Carousel Section */
    .case-studies-carousel-section {
        margin-top: 55px;
        padding-top: 45px;
        border-top: 1px solid rgba(139, 92, 246, 0.16);
        margin-bottom: 45px;
        width: 100%;
        box-sizing: border-box;
    }

    .case-studies-header-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 28px;
    }

    .carousel-nav-controls {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .carousel-arrow-btn {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
    }

    .carousel-arrow-btn:hover {
        background: #7c3aed;
        color: #ffffff;
        border-color: #7c3aed;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(124, 58, 237, 0.3);
    }

    .carousel-arrow-btn:active {
        transform: translateY(0);
    }

    .case-studies-track-wrap {
        width: 100%;
        overflow-x: auto;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding: 8px 4px 22px 4px;
        box-sizing: border-box;
    }

    .case-studies-track-wrap::-webkit-scrollbar {
        display: none;
    }

    .case-studies-track {
        display: flex;
        gap: 26px;
        width: max-content;
        transition: transform 0.35s ease;
    }

    .case-study-card {
        width: 360px;
        flex: 0 0 360px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        box-sizing: border-box;
        scroll-snap-align: start;
    }

    .case-study-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 36px rgba(139, 92, 246, 0.12);
        border-color: rgba(139, 92, 246, 0.35);
    }

    .case-study-img-wrap {
        height: 225px;
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
    }

    .case-study-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .case-study-card:hover .case-study-img-wrap img {
        transform: scale(1.05);
    }

    .case-cat-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(15, 23, 42, 0.78);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }

    .case-guests-badge {
        position: absolute;
        bottom: 14px;
        right: 14px;
        background: rgba(15, 23, 42, 0.78);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }

    .case-study-body {
        padding: 22px 22px 24px 22px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .case-study-title {
        font-size: 21px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 12px 0;
        line-height: 1.3;
        min-height: 54px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .case-study-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 14px;
        font-size: 13.5px;
        color: #64748b;
        min-height: 52px;
    }

    .case-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .case-meta-item i {
        font-size: 13px;
        flex-shrink: 0;
    }

    .case-study-summary {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
        margin: 0 0 22px 0;
        min-height: 68px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .case-study-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }

    .view-dossier-btn {
        flex: 1;
        background: #f3e8ff;
        color: #7c3aed;
        border: 1px solid rgba(124, 58, 237, 0.15);
        padding: 11px 14px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .view-dossier-btn:hover {
        background: #ebd5ff;
        color: #6d28d9;
        transform: translateY(-2px);
    }

    .book-similar-btn {
        flex: 1;
        background: linear-gradient(135deg, #6366f1, #7c3aed);
        color: #ffffff;
        border: none;
        padding: 11px 14px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        transition: all 0.2s ease;
    }

    .book-similar-btn:hover {
        background: linear-gradient(135deg, #4f46e5, #6d28d9);
        box-shadow: 0 6px 18px rgba(99, 102, 241, 0.5);
        transform: translateY(-2px);
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .case-studies-header-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        .carousel-nav-controls {
            align-self: flex-end;
        }
        .case-study-card {
            width: 300px;
            flex: 0 0 300px;
        }
    }
</style>
@endpush

@section('content')
<div class="home-wrapper">
    <!-- 1. 100% FULL-WIDTH LUXURY HERO SECTION (LIGHT & BRIGHT) -->
    <section class="cinematic-hero-wrap" id="hero">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>

        <div class="cinematic-hero-content">
            <!-- Trust Badge Pill -->
            <div class="hero-live-badge">
                <span class="pulse-indicator"></span>
                <span>Sri Lanka's Premier Event Marketplace</span>
                <span style="opacity: 0.35;">•</span>
                <span>1,200+ Celebrations Planned</span>
            </div>

            <!-- Main Headline -->
            <h1 class="cinematic-title">
                Crafting Unforgettable Moments <span>Across Sri Lanka.</span>
            </h1>

            <p class="cinematic-sub">
                Connect with handpicked wedding florists, traditional Poruwa masters, concert audio engineers, and 5-star beachfront resorts — all backed by upfront transparent LKR pricing and dedicated coordination.
            </p>

            <!-- Dual Primary Actions (Best UX for Conversion) -->
            <div class="hero-cta-group">
                <a href="{{ route('events.index') }}" class="hero-btn-primary">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Plan Your Event</span>
                </a>
                <a href="{{ route('food-calculator') }}" class="hero-btn-secondary">
                    <i class="fas fa-calculator" style="color: #059669;"></i>
                    <span>Food Budget Tool</span>
                </a>
            </div>

            <!-- Trust Proof Highlights -->
            <div class="hero-trust-features">
                <div class="hero-trust-item">
                    <i class="fas fa-shield-check" style="color: #059669;"></i>
                    <span>100% Vetted Sri Lankan Vendors</span>
                </div>
                <div class="hero-trust-item">
                    <i class="fas fa-tags" style="color: #2563eb;"></i>
                    <span>Transparent Upfront LKR Pricing</span>
                </div>
                <div class="hero-trust-item">
                    <i class="fas fa-star" style="color: #d97706;"></i>
                    <span>4.9 / 5.0 Rated Client Experience</span>
                </div>
            </div>

            <!-- 2. PLATFORM TRUST METRICS BAR (EMBEDDED FLOATING FULL-WIDTH) -->
            <div class="cinematic-stats-bar">
                <div class="cinematic-stat-item">
                    <div class="cinematic-stat-icon" style="background: rgba(139, 92, 246, 0.12); color: #8b5cf6;">
                        <i class="fas fa-glass-cheers"></i>
                    </div>
                    <div>
                        <div class="cinematic-stat-num">1,200+</div>
                        <div class="cinematic-stat-label">Celebrations Executed</div>
                    </div>
                </div>

                <div class="cinematic-stat-item">
                    <div class="cinematic-stat-icon" style="background: rgba(236, 72, 153, 0.12); color: #ec4899;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <div class="cinematic-stat-num">{{ $supplierCount > 0 ? $supplierCount : '450' }}+</div>
                        <div class="cinematic-stat-label">Verified Suppliers</div>
                    </div>
                </div>

                <div class="cinematic-stat-item">
                    <div class="cinematic-stat-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div>
                        <div class="cinematic-stat-num">100%</div>
                        <div class="cinematic-stat-label">Transparent LKR Rates</div>
                    </div>
                </div>

                <div class="cinematic-stat-item">
                    <div class="cinematic-stat-icon" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <div class="cinematic-stat-num">4.9 / 5.0</div>
                        <div class="cinematic-stat-label">Client Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. FULL WIDTH CONTENT SECTION -->
    <div class="home-content-wrap">
        <!-- 3. EVENT CATEGORIES (BEST UX SHOWCASE) -->
        <section class="page-section" id="services">
            <div style="text-align: center; margin-bottom: 28px;">
                <div class="hero-badge-pill">
                    <i class="fas fa-layer-group"></i> Event Categories
                </div>
                <h2 style="font-size: 36px; font-weight: 800;">Choose Your Event Category</h2>
                <p style="color: var(--text-muted); font-size: 15.5px; max-width: 720px; margin: 8px auto 0; line-height: 1.6;">Select an event type below to browse accredited vendor packages, itemized services, and customize your celebration.</p>
            </div>

            <!-- Interactive Category Filter Navigation (Instant Filtering) -->
            <div class="category-filter-pills">
                <button type="button" class="cat-pill active" data-filter="all">
                    <i class="fas fa-sparkles"></i> All Categories (6)
                </button>
                <button type="button" class="cat-pill" data-filter="wedding">
                    <i class="fas fa-ring" style="color: #ec4899;"></i> Royal Weddings
                </button>
                <button type="button" class="cat-pill" data-filter="dj">
                    <i class="fas fa-compact-disc" style="color: #8b5cf6;"></i> DJ & Audio
                </button>
                <button type="button" class="cat-pill" data-filter="birthday">
                    <i class="fas fa-birthday-cake" style="color: #f59e0b;"></i> Birthdays
                </button>
                <button type="button" class="cat-pill" data-filter="hotel">
                    <i class="fas fa-hotel" style="color: #3b82f6;"></i> Luxury Venues
                </button>
                <button type="button" class="cat-pill" data-filter="gettogether">
                    <i class="fas fa-users" style="color: #10b981;"></i> Social Mixers
                </button>
                <button type="button" class="cat-pill" data-filter="corporate">
                    <i class="fas fa-briefcase" style="color: #6366f1;"></i> Bespoke & Corp
                </button>
            </div>

            <!-- 6-Card Symmetrical Full-Width Showcase Grid -->
            <div class="event-showcase-grid">
                <!-- 1. Weddings & Poruwa -->
                <div class="event-showcase-card" data-category="wedding">
                    <div>
                        <div class="event-card-img-wrap">
                            <img src="{{ asset('assets/images/weding.jpg') }}" alt="Weddings & Poruwa Ceremonies" class="event-card-img" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=700&auto=format&fit=crop&q=80'">
                            <span class="event-rating-badge">
                                <i class="fas fa-star" style="color: #f59e0b;"></i> 4.9 <span style="opacity: 0.75; font-weight: 500;">(420+)</span>
                            </span>
                            <span class="event-badge-tag" style="background: rgba(236, 72, 153, 0.92);">Royal Weddings</span>
                        </div>
                        <h3 class="event-card-title">Weddings & Poruwa Ceremonies</h3>
                        <p class="event-card-desc">
                            Traditional Poruwa masters, Ashtaka chanters, Ves dancers, bridal floral decors, gourmet banquet catering, and cinematic 4K drone videography.
                        </p>
                        <div class="event-card-chips">
                            <span class="event-chip"><i class="fas fa-gem" style="color: #ec4899;"></i> Poruwa Rituals</span>
                            <span class="event-chip"><i class="fas fa-video" style="color: #8b5cf6;"></i> 4K Cinema Drone</span>
                            <span class="event-chip"><i class="fas fa-drum" style="color: #f59e0b;"></i> Ves Dancers</span>
                        </div>
                        <div class="event-card-meta-bar">
                            <span class="meta-vendors"><i class="fas fa-user-check"></i> 120+ Curated Vendors</span>
                        </div>
                    </div>
                    <div class="event-card-actions">
                        <a href="{{ route('events.weddings') }}" class="event-btn-outline">
                            <i class="fas fa-eye"></i> View Showcase
                        </a>
                        <a href="{{ route('booking.create', ['event' => 'Wedding']) }}" class="event-btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Event
                        </a>
                    </div>
                </div>

                <!-- 2. DJ Parties & Concert Audio -->
                <div class="event-showcase-card" data-category="dj">
                    <div>
                        <div class="event-card-img-wrap">
                            <img src="{{ asset('assets/images/dj.jpg') }}" alt="DJ Parties & Concert Audio" class="event-card-img" onerror="this.src='https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=700&auto=format&fit=crop&q=80'">
                            <span class="event-rating-badge">
                                <i class="fas fa-star" style="color: #f59e0b;"></i> 4.9 <span style="opacity: 0.75; font-weight: 500;">(280+)</span>
                            </span>
                            <span class="event-badge-tag" style="background: rgba(139, 92, 246, 0.92);">Club Beats</span>
                        </div>
                        <h3 class="event-card-title">DJ Parties & Concert Audio</h3>
                        <p class="event-card-desc">
                            JBL line-array sound systems, intelligent moving heads, strobe lights, headline EDM/commercial DJs, crowd control, and mobile mixology cocktail bars.
                        </p>
                        <div class="event-card-chips">
                            <span class="event-chip"><i class="fas fa-volume-up" style="color: #8b5cf6;"></i> JBL Line Array</span>
                            <span class="event-chip"><i class="fas fa-lightbulb" style="color: #ec4899;"></i> Moving Heads</span>
                            <span class="event-chip"><i class="fas fa-cocktail" style="color: #10b981;"></i> Mobile Bar</span>
                        </div>
                        <div class="event-card-meta-bar">
                            <span class="meta-vendors"><i class="fas fa-user-check"></i> 45+ Sound Crews</span>
                        </div>
                    </div>
                    <div class="event-card-actions">
                        <a href="{{ route('events.dj-parties') }}" class="event-btn-outline">
                            <i class="fas fa-eye"></i> View Showcase
                        </a>
                        <a href="{{ route('booking.create', ['event' => 'DJ Party']) }}" class="event-btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Event
                        </a>
                    </div>
                </div>

                <!-- 3. Birthdays & Anniversaries -->
                <div class="event-showcase-card" data-category="birthday">
                    <div>
                        <div class="event-card-img-wrap">
                            <img src="{{ asset('assets/images/cake.jpg') }}" alt="Birthdays & Anniversaries" class="event-card-img" onerror="this.src='https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=700&auto=format&fit=crop&q=80'">
                            <span class="event-rating-badge">
                                <i class="fas fa-star" style="color: #f59e0b;"></i> 4.8 <span style="opacity: 0.75; font-weight: 500;">(310+)</span>
                            </span>
                            <span class="event-badge-tag" style="background: rgba(245, 158, 11, 0.92);">Milestones</span>
                        </div>
                        <h3 class="event-card-title">Birthdays & Anniversaries</h3>
                        <p class="event-card-desc">
                            Artisan sculpted fondant cakes, pastel balloon garlands, kids entertainers, cartoon mascot appearances, sweet dessert tables, and themed catering.
                        </p>
                        <div class="event-card-chips">
                            <span class="event-chip"><i class="fas fa-birthday-cake" style="color: #f59e0b;"></i> Fondant Cakes</span>
                            <span class="event-chip"><i class="fas fa-hat-wizard" style="color: #8b5cf6;"></i> Kids Entertainers</span>
                            <span class="event-chip"><i class="fas fa-icons" style="color: #ec4899;"></i> Balloon Arches</span>
                        </div>
                        <div class="event-card-meta-bar">
                            <span class="meta-vendors"><i class="fas fa-user-check"></i> 60+ Entertainers</span>
                        </div>
                    </div>
                    <div class="event-card-actions">
                        <a href="{{ route('events.birthdays') }}" class="event-btn-outline">
                            <i class="fas fa-eye"></i> View Showcase
                        </a>
                        <a href="{{ route('booking.create', ['event' => 'Birthday']) }}" class="event-btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Event
                        </a>
                    </div>
                </div>

                <!-- 4. Hotel Venues & Halls -->
                <div class="event-showcase-card" data-category="hotel">
                    <div>
                        <div class="event-card-img-wrap">
                            <img src="{{ asset('assets/images/hotel.jpg') }}" alt="5-Star Hotel Venues & Halls" class="event-card-img" onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=700&auto=format&fit=crop&q=80'">
                            <span class="event-rating-badge">
                                <i class="fas fa-star" style="color: #f59e0b;"></i> 5.0 <span style="opacity: 0.75; font-weight: 500;">(190+)</span>
                            </span>
                            <span class="event-badge-tag" style="background: rgba(59, 130, 246, 0.92);">Luxury Venues</span>
                        </div>
                        <h3 class="event-card-title">5-Star Hotel Venues & Halls</h3>
                        <p class="event-card-desc">
                            Grand crystal ballrooms, beachfront lawns, international buffet menus, luxury guest room blocks, bridal changing suites, and ample secure valet parking.
                        </p>
                        <div class="event-card-chips">
                            <span class="event-chip"><i class="fas fa-water" style="color: #3b82f6;"></i> Oceanfront Lawns</span>
                            <span class="event-chip"><i class="fas fa-utensils" style="color: #f59e0b;"></i> 5-Star Buffets</span>
                            <span class="event-chip"><i class="fas fa-parking" style="color: #10b981;"></i> Valet Parking</span>
                        </div>
                        <div class="event-card-meta-bar">
                            <span class="meta-vendors"><i class="fas fa-user-check"></i> 25+ 5-Star Venues</span>
                        </div>
                    </div>
                    <div class="event-card-actions">
                        <a href="{{ route('events.hotels') }}" class="event-btn-outline">
                            <i class="fas fa-eye"></i> View Showcase
                        </a>
                        <a href="{{ route('booking.create', ['event' => 'Hotel Venue']) }}" class="event-btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Event
                        </a>
                    </div>
                </div>

                <!-- 5. Social Reunions & Get-Togethers -->
                <div class="event-showcase-card" data-category="gettogether">
                    <div>
                        <div class="event-card-img-wrap">
                            <img src="{{ asset('assets/images/evnt.jpg') }}" alt="Social Reunions & Get-Togethers" class="event-card-img" onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=700&auto=format&fit=crop&q=80'">
                            <span class="event-rating-badge">
                                <i class="fas fa-star" style="color: #f59e0b;"></i> 4.9 <span style="opacity: 0.75; font-weight: 500;">(160+)</span>
                            </span>
                            <span class="event-badge-tag" style="background: rgba(16, 185, 129, 0.92);">Social Mixers</span>
                        </div>
                        <h3 class="event-card-title">Social Reunions & Get-Togethers</h3>
                        <p class="event-card-desc">
                            Casual garden parties, alumni reunions, live charcoal BBQ skewer setups, acoustic guitar sets, canopy marquee rentals, and lawn game packages.
                        </p>
                        <div class="event-card-chips">
                            <span class="event-chip"><i class="fas fa-fire" style="color: #ef4444;"></i> Live Charcoal BBQ</span>
                            <span class="event-chip"><i class="fas fa-guitar" style="color: #8b5cf6;"></i> Acoustic Trio</span>
                            <span class="event-chip"><i class="fas fa-campground" style="color: #10b981;"></i> Marquee Pergolas</span>
                        </div>
                        <div class="event-card-meta-bar">
                            <span class="meta-vendors"><i class="fas fa-user-check"></i> 35+ Rental Partners</span>
                        </div>
                    </div>
                    <div class="event-card-actions">
                        <a href="{{ route('events.get-together') }}" class="event-btn-outline">
                            <i class="fas fa-eye"></i> View Showcase
                        </a>
                        <a href="{{ route('booking.create', ['event' => 'Get Together']) }}" class="event-btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Event
                        </a>
                    </div>
                </div>

                <!-- 6. Bespoke & Corporate Galas (Creates Perfect 3x2 Grid Balance) -->
                <div class="event-showcase-card" data-category="corporate">
                    <div>
                        <div class="event-card-img-wrap">
                            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=700&auto=format&fit=crop&q=80" alt="Corporate & Bespoke Galas" class="event-card-img">
                            <span class="event-rating-badge">
                                <i class="fas fa-star" style="color: #f59e0b;"></i> 4.9 <span style="opacity: 0.75; font-weight: 500;">(95+)</span>
                            </span>
                            <span class="event-badge-tag" style="background: rgba(99, 102, 241, 0.92);">Bespoke & Corp</span>
                        </div>
                        <h3 class="event-card-title">Corporate & Bespoke Galas</h3>
                        <p class="event-card-desc">
                            Annual awards ceremonies, corporate brand activations, executive banquets, product launches, and customized multi-day itineraries with dedicated manager.
                        </p>
                        <div class="event-card-chips">
                            <span class="event-chip"><i class="fas fa-trophy" style="color: #f59e0b;"></i> Awards Galas</span>
                            <span class="event-chip"><i class="fas fa-microphone-alt" style="color: #3b82f6;"></i> Keynote Staging</span>
                            <span class="event-chip"><i class="fas fa-user-shield" style="color: #6366f1;"></i> Event Concierge</span>
                        </div>
                        <div class="event-card-meta-bar">
                            <span class="meta-vendors"><i class="fas fa-bolt" style="color: #f59e0b;"></i> 24h Concierge Turnaround</span>
                        </div>
                    </div>
                    <div class="event-card-actions">
                        <a href="{{ route('events.index') }}" class="event-btn-outline">
                            <i class="fas fa-th-large"></i> All Services
                        </a>
                        <a href="{{ route('booking.create') }}" class="event-btn-primary">
                            <i class="fas fa-calendar-plus"></i> Custom Booking
                        </a>
                    </div>
                </div>
            </div>

            <!-- Executed Celebrations & Case Studies Showcase (Horizontal Carousel UX) -->
            <div class="case-studies-carousel-section">
                <div class="case-studies-header-row">
                    <div>
                        <div class="hero-badge-pill" style="background: rgba(236, 72, 153, 0.08); color: #db2777; border-color: rgba(236, 72, 153, 0.2); margin-bottom: 8px;">
                            <i class="fas fa-photo-video"></i> Real Executed Portfolio
                        </div>
                        <h2 style="font-size: 32px; font-weight: 800; color: var(--text-heading); margin: 0 0 6px 0;">Executed Celebrations & Case Studies</h2>
                        <p style="color: var(--text-muted); font-size: 15px; margin: 0;">
                            Swipe through authentic weddings, concerts, milestone birthdays, and retreats delivered across Sri Lanka.
                        </p>
                    </div>
                    <div class="carousel-nav-controls">
                        <button type="button" class="carousel-arrow-btn" id="caseStudiesPrev" aria-label="Previous Showcase">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="carousel-arrow-btn" id="caseStudiesNext" aria-label="Next Showcase">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="case-studies-track-wrap" id="caseStudiesTrackWrap">
                    <div class="case-studies-track" id="caseStudiesTrack">
                        @if(!empty($allCaseStudies))
                            @foreach($allCaseStudies as $case)
                                @php
                                    $badgeColor = match($case['category_filter'] ?? 'wedding') {
                                        'wedding' => '#ec4899',
                                        'dj' => '#8b5cf6',
                                        'birthday' => '#f59e0b',
                                        'hotel' => '#3b82f6',
                                        'gettogether' => '#10b981',
                                        'corporate' => '#6366f1',
                                        default => '#ec4899'
                                    };
                                @endphp
                                <div class="case-study-card home-case-study-card" data-category="{{ $case['category_filter'] ?? 'wedding' }}">
                                    <div class="case-study-img-wrap">
                                        <img src="{{ asset($case['image'] ?? 'assets/images/weding.jpg') }}" alt="{{ $case['title'] }}" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=800'">
                                        <div class="case-cat-badge">{{ $case['category_lbl'] ?? $case['category_name'] }}</div>
                                        <div class="case-guests-badge">
                                            <i class="fas fa-users"></i> {{ $case['guests'] ?? '150+' }} Guests
                                        </div>
                                    </div>

                                    <div class="case-study-body">
                                        <div>
                                            <h3 class="case-study-title">{{ $case['title'] }}</h3>
                                            <div class="case-study-meta">
                                                <div class="case-meta-item">
                                                    <i class="fas fa-map-marker-alt" style="color: {{ $badgeColor }};"></i>
                                                    <span>{{ $case['venue'] }}</span>
                                                </div>
                                                <div class="case-meta-item">
                                                    <i class="far fa-calendar-alt" style="color: {{ $badgeColor }};"></i>
                                                    <span>{{ $case['date'] }}</span>
                                                </div>
                                            </div>
                                            <p class="case-study-summary">{{ $case['summary'] }}</p>
                                        </div>

                                        <div class="case-study-actions">
                                            <a href="{{ $case['showcase_route'] }}" class="view-dossier-btn">
                                                <i class="fas fa-info-circle"></i> View Dossier
                                            </a>
                                            <a href="{{ route('booking.create', [
                                                'event' => $case['category_name'],
                                                'venue' => $case['venue'],
                                                'guests' => $case['guests'] ?? 150,
                                                'details' => 'Inspired by ' . $case['title']
                                            ]) }}" class="book-similar-btn">
                                                <i class="fas fa-check"></i> Book Similar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Helpful Concierge Assistance Strip -->
            <div class="category-concierge-strip">
                <div class="concierge-strip-content">
                    <div class="concierge-strip-icon">
                        <i class="fas fa-magic"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 16px; font-weight: 800; color: var(--text-heading); margin-bottom: 4px;">
                            Looking for a multi-day itinerary or bespoke celebration?
                        </h4>
                        <p style="font-size: 13.5px; color: var(--text-muted); margin: 0;">
                            Our event specialists match you with verified florists, sound crews, and 5-star venues in under 24 hours.
                        </p>
                    </div>
                </div>
                <div style="display: flex; gap: 12px; flex-shrink: 0;">
                    <a href="{{ route('food-calculator') }}" class="btn-concierge-sec">
                        <i class="fas fa-calculator" style="color: #059669;"></i> Food Budget Tool
                    </a>
                    <a href="#contact" class="btn-concierge-prim">
                        <i class="fas fa-headset"></i> Talk to Specialist
                    </a>
                </div>
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

        <!-- 5. ABOUT US: OUR STORY, OUR VISION & OUR MISSION -->
        <section class="about-story-section" id="about">
            <div class="about-header-wrap">
                <div class="hero-badge-pill">
                    <i class="fas fa-heart"></i> The Heart of Eventflare
                </div>
                <h2 class="about-main-title">Crafted in Sri Lanka. Dedicated to Life's Greatest Moments.</h2>
                <p class="about-main-subtitle">
                    The story, vision, and everyday mission powering Sri Lanka's first unified, transparent celebration marketplace.
                </p>
            </div>

            <div class="about-story-grid">
                <!-- Left: Our Story Showcase Card -->
                <div class="story-showcase-card">
                    <div>
                        <div class="vm-card-top" style="margin-bottom: 24px;">
                            <div class="vm-icon-bubble vision-bubble">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <span class="vm-badge-label vision-label">
                                <i class="fas fa-history"></i> OUR STORY
                            </span>
                        </div>

                        <div class="story-content-body">
                            <h3 class="story-title">From Fragmentation to Flawless Celebrations</h3>
                            <p class="story-text">
                                Planning a wedding, milestone birthday, or corporate banquet in Sri Lanka has historically meant hundreds of fragmented WhatsApp threads, untraceable quotes, hidden venue surcharges, and anxious double-booking worries.
                            </p>
                            <p class="story-text">
                                We created <strong>EVENTFLARE</strong> with a singular purpose: to bring dignity, radical transparency, and digital elegance to event hosting. By gathering premier florists, audio engineers, five-star banquet managers, and culinary masters under one accredited roof, we turn months of chaotic coordination into a serene, joyful experience.
                            </p>

                            <div class="story-quote-box">
                                <i class="fas fa-quote-left story-quote-icon"></i>
                                <div>
                                    <div class="story-quote-body">
                                        "Every milestone in Sri Lanka deserves the certainty of accredited excellence, transparent LKR pricing, and zero compromise."
                                    </div>
                                    <div class="story-quote-author">— The Eventflare Founding Team, Colombo</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="story-actions">
                        <a href="{{ route('events.index') }}" class="btn btn-primary" style="padding: 11px 22px; font-weight: 700; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-compass"></i> Discover Services
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline" style="border: 1px solid #cbd5e1; color: var(--text-main); padding: 11px 20px; font-weight: 700; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px;">
                            Read Full Story <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
                        </a>
                    </div>
                </div>

                <!-- Right: Vision & Mission Stack -->
                <div class="vision-mission-column">
                    <!-- Our Vision -->
                    <div class="vm-card vision-card">
                        <div class="vm-card-top">
                            <div class="vm-icon-bubble vision-bubble">
                                <i class="fas fa-eye"></i>
                            </div>
                            <span class="vm-badge-label vision-label">
                                <i class="fas fa-satellite-dish"></i> OUR VISION
                            </span>
                        </div>

                        <div>
                            <h3 class="vm-title">Sri Lanka's Digital Celebration Benchmark</h3>
                            <p class="vm-body" style="margin-top: 8px;">
                                To establish South Asia’s gold-standard event technology ecosystem — empowering resident families and the global Sri Lankan diaspora to discover, personalize, and book world-class celebrations with absolute confidence, transparency, and cultural pride.
                            </p>
                        </div>

                        <div class="vm-bullet-list">
                            <div class="vm-bullet-item">
                                <i class="fas fa-check-circle"></i>
                                <span><strong>Empowering Local Artisans:</strong> Providing island-wide digital visibility and prompt payouts for authentic creative professionals.</span>
                            </div>
                            <div class="vm-bullet-item">
                                <i class="fas fa-check-circle"></i>
                                <span><strong>Global Diaspora Access:</strong> Seamless overseas booking and remote concierge tracking for Sri Lankans celebrating back home.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Our Mission -->
                    <div class="vm-card mission-card">
                        <div class="vm-card-top">
                            <div class="vm-icon-bubble mission-bubble">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <span class="vm-badge-label mission-label">
                                <i class="fas fa-gem"></i> OUR MISSION
                            </span>
                        </div>

                        <div>
                            <h3 class="vm-title">Eliminating Stress. Elevating Celebrations.</h3>
                            <p class="vm-body" style="margin-top: 8px;">
                                Our daily mandate is to protect host peace of mind through strict supplier accreditation, upfront itemized LKR rates, and continuous concierge support.
                            </p>
                        </div>

                        <div class="vm-pillar-grid">
                            <div class="vm-pillar-item">
                                <i class="fas fa-shield-alt"></i>
                                <span class="vm-pillar-name">Accredited Quality</span>
                                <span class="vm-pillar-desc">Multi-point vetted portfolios & service SLAs</span>
                            </div>
                            <div class="vm-pillar-item">
                                <i class="fas fa-receipt"></i>
                                <span class="vm-pillar-name">100% Upfront Rates</span>
                                <span class="vm-pillar-desc">Itemized quotes, zero hidden venue surcharges</span>
                            </div>
                            <div class="vm-pillar-item">
                                <i class="fas fa-user-shield"></i>
                                <span class="vm-pillar-name">Host Concierge</span>
                                <span class="vm-pillar-desc">Unified dossiers and supplier accountability</span>
                            </div>
                        </div>

                        <div class="mission-partner-footer">
                            <span class="mission-partner-text">
                                <i class="fas fa-handshake" style="color: #059669; margin-right: 6px;"></i> Are you a verified vendor or venue?
                            </span>
                            <a href="{{ route('supplier.register') }}" class="btn btn-sm" style="background: rgba(16, 185, 129, 0.12); color: #047857; font-weight: 700; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 10px; padding: 7px 14px; font-size: 12.5px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                                <i class="fas fa-store"></i> Partner With Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Island-Wide Milestone Footprint Ribbon -->
            <div class="about-milestone-ribbon">
                <div class="milestone-box">
                    <div class="milestone-icon-wrap">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="milestone-content">
                        <span class="milestone-number">9 Provinces</span>
                        <span class="milestone-desc">Island-Wide Logistics & Venue Coverage</span>
                    </div>
                </div>

                <div class="milestone-box">
                    <div class="milestone-icon-wrap">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="milestone-content">
                        <span class="milestone-number">450+ Certified</span>
                        <span class="milestone-desc">Audited Creative Suppliers & Vendors</span>
                    </div>
                </div>

                <div class="milestone-box">
                    <div class="milestone-icon-wrap">
                        <i class="fas fa-glass-cheers"></i>
                    </div>
                    <div class="milestone-content">
                        <span class="milestone-number">1,200+ Events</span>
                        <span class="milestone-desc">Executed with 0% Cancellation Rate</span>
                    </div>
                </div>

                <div class="milestone-box">
                    <div class="milestone-icon-wrap" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="milestone-content">
                        <span class="milestone-number">4.9 / 5.0</span>
                        <span class="milestone-desc">Verified Client Satisfaction Rating</span>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.cat-pill');
        const cards = document.querySelectorAll('.event-showcase-grid .event-showcase-card');
        const caseCards = document.querySelectorAll('.case-studies-track .home-case-study-card');
        const trackWrap = document.getElementById('caseStudiesTrackWrap');
        const prevBtn = document.getElementById('caseStudiesPrev');
        const nextBtn = document.getElementById('caseStudiesNext');

        if (trackWrap && prevBtn && nextBtn) {
            const scrollStep = 386; // 360px card width + 26px gap
            prevBtn.addEventListener('click', function() {
                trackWrap.scrollBy({ left: -scrollStep, behavior: 'smooth' });
            });
            nextBtn.addEventListener('click', function() {
                trackWrap.scrollBy({ left: scrollStep, behavior: 'smooth' });
            });
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                cards.forEach(card => {
                    if (filter === 'all' || card.getAttribute('data-category') === filter) {
                        card.style.display = 'flex';
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.style.transition = 'opacity 0.3s ease, transform 0.35s ease';
                            card.style.opacity = '1';
                        }, 30);
                    } else {
                        card.style.display = 'none';
                    }
                });

                caseCards.forEach(card => {
                    if (filter === 'all' || card.getAttribute('data-category') === filter) {
                        card.style.display = 'flex';
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.style.transition = 'opacity 0.3s ease, transform 0.35s ease';
                            card.style.opacity = '1';
                        }, 30);
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (trackWrap) {
                    trackWrap.scrollTo({ left: 0, behavior: 'smooth' });
                }
            });
        });
    });
</script>
@endsection