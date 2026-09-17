@extends('layouts.eventflare')

@php
    $categoryName = $wizardConfig['category_name'] ?? 'Weddings';
@endphp

@section('title', 'Book Your Celebration — ' . $categoryName . ' — EVENTFLARE')

@section('content')

{{-- =========================================================================
     UNIVERSAL 4-STAGE INTERACTIVE EVENT BOOKING WIZARD ENGINE
     Powers Weddings, DJ Parties, Birthdays, Hotel Venues & Get Togethers
========================================================================= --}}
<style>
    :root {
        --primary-glow: {{ $wizardConfig['theme_colors']['primary_glow'] }};
        --secondary-glow: {{ $wizardConfig['theme_colors']['secondary_glow'] }};
        --accent: {{ $wizardConfig['theme_colors']['accent'] }};
        --accent-glow: {{ $wizardConfig['theme_colors']['accent_glow'] }};
        --surface-glass: rgba(20, 18, 35, 0.72);
        --surface-glass-card: {{ $wizardConfig['theme_colors']['surface_glass_card'] }};
        --surface-glass-border: rgba(255, 255, 255, 0.12);
        --surface-glass-active: {{ $wizardConfig['theme_colors']['active_bg'] }};
        --active-border: {{ $wizardConfig['theme_colors']['active_border'] }};
        --badge-accent: {{ $wizardConfig['theme_colors']['badge_color'] }};
        --text-dim: #94a3b8;
        --radius-lg: 24px;
        --radius-md: 16px;
        --radius-sm: 10px;
        --shadow-glass: 0 20px 50px rgba(0, 0, 0, 0.5), inset 0 1px 1px rgba(255, 255, 255, 0.15);
    }

    .wizard-wrapper {
        position: relative;
        overflow: hidden;
        min-height: calc(100vh - 120px);
        padding: 40px 20px 80px;
    }

    /* Ambient Glowing Orbs */
    .ambient-orb {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        filter: blur(90px);
        opacity: 0.45;
        animation: floatOrb 20s ease-in-out infinite alternate;
    }
    .orb-1 {
        width: 500px; height: 500px;
        background: {{ $wizardConfig['theme_colors']['orb_1'] }};
        top: -80px; left: -120px;
    }
    .orb-2 {
        width: 440px; height: 440px;
        background: {{ $wizardConfig['theme_colors']['orb_2'] }};
        bottom: 40px; right: -80px;
        animation-duration: 24s;
    }
    .orb-3 {
        width: 340px; height: 340px;
        background: {{ $wizardConfig['theme_colors']['orb_3'] }};
        top: 35%; right: 20%;
        opacity: 0.28;
        animation-duration: 28s;
    }

    @keyframes floatOrb {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(50px, 30px) scale(1.06); }
        100% { transform: translate(-30px, 60px) scale(0.96); }
    }

    .wizard-container {
        max-width: 1260px;
        margin: 0 auto;
        position: relative;
        z-index: 10;
    }

    /* Wizard Header */
    .wizard-header {
        text-align: center;
        margin-bottom: 34px;
    }
    .curated-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--surface-glass-active);
        border: 1px solid var(--active-border);
        color: var(--badge-accent);
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 12px;
        box-shadow: 0 0 25px var(--primary-glow);
    }
    .category-hook-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #e2e8f0;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 14px;
    }
    .wizard-title {
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 900;
        color: #fff;
        line-height: 1.15;
        margin-bottom: 10px;
    }
    .wizard-subtitle {
        font-size: 15px;
        color: var(--text-dim);
        max-width: 720px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* 4-Stage Stepper */
    .progress-stepper {
        background: var(--surface-glass);
        border: 1px solid var(--surface-glass-border);
        border-radius: var(--radius-lg);
        padding: 24px 32px;
        margin-bottom: 32px;
        box-shadow: var(--shadow-glass);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    .stepper-track {
        position: relative;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .stepper-track::before {
        content: '';
        position: absolute;
        top: 24px; left: 12%; right: 12%;
        height: 3px;
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
    }
    .stepper-progress-fill {
        position: absolute;
        top: 24px; left: 12%; height: 3px;
        background: linear-gradient(90deg, var(--accent), var(--badge-accent));
        z-index: 2;
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 12px var(--accent-glow);
    }
    .step-node {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .node-bubble {
        width: 48px; height: 48px; border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(255, 255, 255, 0.18);
        color: var(--text-dim);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 15px;
        margin-bottom: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }
    .step-node.active .node-bubble {
        background: var(--accent);
        border-color: #fff;
        color: #111;
        box-shadow: 0 0 24px var(--accent-glow);
        transform: scale(1.12);
    }
    .step-node.completed .node-bubble {
        background: #10b981;
        border-color: #34d399;
        color: #fff;
        box-shadow: 0 0 18px rgba(16, 185, 129, 0.5);
    }
    .node-label {
        font-size: 14px; font-weight: 800; color: #fff; margin-bottom: 3px;
    }
    .step-node:not(.active):not(.completed) .node-label {
        color: var(--text-dim);
    }
    .node-subtext {
        font-size: 11px; color: var(--text-dim); text-transform: uppercase; letter-spacing: 0.5px;
    }

    /* Layout Grid */
    .wizard-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 32px;
        align-items: start;
    }

    /* Stage Panel & Glass Cards */
    .stage-card {
        background: var(--surface-glass);
        border: 1px solid var(--surface-glass-border);
        border-radius: var(--radius-lg);
        padding: 36px;
        box-shadow: var(--shadow-glass);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }
    .stage-pane {
        display: none;
        animation: fadeInPane 0.4s ease forwards;
    }
    .stage-pane.active {
        display: block;
    }
    @keyframes fadeInPane {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .pane-header {
        margin-bottom: 28px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .pane-step-tag {
        font-size: 12px; font-weight: 800; color: var(--accent);
        text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px;
    }
    .pane-title {
        font-size: 24px; font-weight: 900; color: #fff; margin: 0 0 6px;
    }
    .pane-desc {
        font-size: 14px; color: var(--text-dim); margin: 0; line-height: 1.5;
    }

    /* Form Inputs */
    .form-group {
        margin-bottom: 22px;
    }
    .form-label {
        display: flex; align-items: center; justify-content: space-between;
        font-size: 13px; font-weight: 700; color: #e2e8f0; margin-bottom: 8px;
    }
    .glass-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: var(--radius-sm);
        padding: 13px 16px;
        font-size: 14px;
        color: #fff;
        outline: none;
        transition: all 0.25s ease;
    }
    .glass-input:focus {
        border-color: var(--accent);
        background: rgba(255, 255, 255, 0.07);
        box-shadow: 0 0 16px var(--accent-glow);
    }
    .glass-input::placeholder {
        color: rgba(255, 255, 255, 0.35);
    }

    /* Selectable Grid Cards */
    .selection-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .selection-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .option-card {
        background: var(--surface-glass-card);
        border: 1.5px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: 20px;
        cursor: pointer;
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        display: flex; flex-direction: column;
        overflow: hidden;
    }
    .option-card:hover {
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.35);
    }
    .option-card.selected {
        border-color: var(--active-border);
        background: var(--surface-glass-active);
        box-shadow: 0 0 24px var(--primary-glow);
    }

    /* Venue Cards in Stage 2 */
    .venues-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }
    .venue-card {
        background: var(--surface-glass-card);
        border: 1.5px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: 18px;
        cursor: pointer;
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        display: flex; flex-direction: column; justify-content: space-between;
    }
    .venue-card:hover {
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.35);
    }
    .venue-card.selected {
        border-color: var(--active-border);
        background: var(--surface-glass-active);
        box-shadow: 0 0 24px var(--primary-glow);
    }
    .venue-card-header {
        display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;
    }
    .venue-name {
        font-size: 15px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px;
    }
    .venue-name i {
        color: var(--accent);
    }
    .venue-badge {
        font-size: 11px; font-weight: 700; color: var(--badge-accent);
        background: rgba(255, 255, 255, 0.08); padding: 3px 8px; border-radius: 12px; white-space: nowrap;
    }
    .venue-desc {
        font-size: 12px; color: var(--text-dim); line-height: 1.4; margin-bottom: 12px;
    }
    .venue-footer {
        display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #cbd5e1;
    }
    .venue-loc i {
        color: #94a3b8; margin-right: 4px;
    }
    .venue-check {
        width: 20px; height: 20px; border-radius: 50%;
        border: 1.5px solid rgba(255, 255, 255, 0.2);
        display: flex; align-items: center; justify-content: center;
        color: transparent; transition: all 0.2s ease;
    }
    .venue-card.selected .venue-check {
        background: var(--accent); border-color: var(--accent); color: #111;
    }

    .venue-input-container {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: 18px 20px;
        margin-top: 10px;
    }

    /* Headcount Slider */
    .slider-container {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: 24px;
    }
    .slider-metrics {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;
    }
    .slider-value-display {
        font-size: 32px; font-weight: 900; color: #fff; display: flex; align-items: baseline; gap: 8px;
    }
    .slider-value-display small {
        font-size: 14px; font-weight: 600; color: var(--text-dim);
    }
    .custom-range {
        width: 100%; height: 8px; border-radius: 6px;
        background: rgba(255, 255, 255, 0.12);
        outline: none; -webkit-appearance: none; appearance: none;
    }
    .custom-range::-webkit-slider-thumb {
        -webkit-appearance: none; appearance: none;
        width: 26px; height: 26px; border-radius: 50%;
        background: var(--accent);
        border: 3px solid #fff;
        cursor: pointer;
        box-shadow: 0 0 16px var(--accent-glow);
        transition: transform 0.15s ease;
    }
    .custom-range::-webkit-slider-thumb:hover {
        transform: scale(1.15);
    }

    /* Artisans / Package Cards in Stage 3 */
    .service-block {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-md);
        padding: 22px;
        margin-bottom: 24px;
    }
    .service-header {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;
    }
    .service-title {
        font-size: 16px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 10px;
    }
    .service-title i {
        color: var(--accent);
    }
    .package-option-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 14px;
    }
    .package-card {
        background: var(--surface-glass-card);
        border: 1.5px solid rgba(255, 255, 255, 0.09);
        border-radius: var(--radius-sm);
        padding: 16px;
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative;
    }
    .package-card:hover {
        border-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }
    .package-card.selected {
        border-color: var(--active-border);
        background: var(--surface-glass-active);
    }
    .package-card-top {
        display: flex; align-items: center; gap: 10px; margin-bottom: 10px;
    }
    .pkg-supplier-thumb {
        width: 38px; height: 38px; border-radius: 8px; object-fit: cover;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .pkg-supplier-name {
        font-size: 11px; font-weight: 700; color: var(--badge-accent); text-transform: uppercase;
    }
    .pkg-title {
        font-size: 14px; font-weight: 800; color: #fff; line-height: 1.3;
    }
    .pkg-price-tag {
        margin-top: 12px; display: flex; align-items: baseline; justify-content: space-between;
    }
    .pkg-amount {
        font-size: 15px; font-weight: 900; color: var(--accent);
    }
    .pkg-type-badge {
        font-size: 10px; font-weight: 700; background: rgba(255, 255, 255, 0.08);
        color: #cbd5e1; padding: 2px 7px; border-radius: 10px;
    }

    /* Stage 4 Dossier Review */
    .dossier-review-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: 24px;
        margin-bottom: 22px;
    }
    .dossier-section-title {
        font-size: 15px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 14px;
        padding-bottom: 8px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dossier-section-title i {
        color: var(--accent);
    }
    .dossier-grid-summary {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        font-size: 13px;
    }
    .dossier-row {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .dossier-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .dossier-val {
        font-weight: 800;
        color: #fff;
    }

    .dossier-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin-top: 10px;
    }
    .dossier-table th {
        text-align: left;
        color: var(--text-dim);
        font-weight: 700;
        padding: 8px 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 11px;
        text-transform: uppercase;
    }
    .dossier-table td {
        padding: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
    }

    /* Live Telemetry Sidebar */
    .telemetry-card {
        background: var(--surface-glass);
        border: 1px solid var(--surface-glass-border);
        border-radius: var(--radius-lg);
        padding: 28px;
        box-shadow: var(--shadow-glass);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        position: sticky;
        top: 90px;
    }
    .telemetry-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px; padding-bottom: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .telemetry-title {
        font-size: 15px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px;
    }
    .telemetry-pulse {
        width: 8px; height: 8px; border-radius: 50%;
        background: #10b981; box-shadow: 0 0 10px #10b981;
        animation: pulseDot 1.8s infinite;
    }
    @keyframes pulseDot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.85); }
    }

    .telemetry-item {
        display: flex; justify-content: space-between; align-items: baseline;
        padding: 10px 0; border-bottom: 1px dashed rgba(255, 255, 255, 0.07);
        font-size: 13px; color: var(--text-dim);
    }
    .telemetry-item strong {
        color: #fff; font-weight: 800;
    }
    .telemetry-total-box {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: var(--radius-md);
        padding: 20px;
        margin-top: 20px;
        text-align: center;
    }
    .total-label {
        font-size: 11px; font-weight: 800; color: var(--text-dim); text-transform: uppercase; letter-spacing: 1px;
    }
    .total-amount {
        font-size: 32px; font-weight: 900; color: var(--accent); margin: 6px 0;
        text-shadow: 0 0 25px var(--accent-glow);
    }

    /* Action Buttons */
    .btn-step-next {
        background: linear-gradient(135deg, var(--accent), #d97706);
        color: #111;
        font-weight: 800;
        padding: 14px 28px;
        border-radius: 30px;
        border: none;
        cursor: pointer;
        display: inline-flex; align-items: center; gap: 10px;
        font-size: 14px;
        box-shadow: 0 8px 24px var(--accent-glow);
        transition: all 0.25s ease;
    }
    .btn-step-next:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px var(--accent-glow);
        color: #000;
    }
    .btn-step-prev {
        background: rgba(255, 255, 255, 0.06);
        color: #cbd5e1;
        font-weight: 700;
        padding: 14px 24px;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 14px;
        transition: all 0.25s ease;
    }
    .btn-step-prev:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    @media (max-width: 992px) {
        .wizard-grid {
            grid-template-columns: 1fr;
        }
        .stepper-track {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .stepper-track::before {
            display: none;
        }
        .venues-grid {
            grid-template-columns: 1fr;
        }
        .selection-grid-3, .selection-grid-2 {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="wizard-wrapper">
    <!-- Ambient Floating Orbs -->
    <div class="ambient-orb orb-1"></div>
    <div class="ambient-orb orb-2"></div>
    <div class="ambient-orb orb-3"></div>

    <div class="wizard-container">
        <!-- Wizard Header -->
        <div class="wizard-header">
            <div>
                <span class="curated-badge">
                    <i class="fas fa-sparkles"></i> {{ $wizardConfig['theme_badge'] }}
                </span>
            </div>
            <div>
                <span class="category-hook-badge">
                    <i class="fas fa-check-circle" style="color: #10b981;"></i> {{ $wizardConfig['alert_hook'] }}
                </span>
            </div>
            <h1 class="wizard-title">
                Book Your Celebration: <span style="color: var(--badge-accent);">{{ $wizardConfig['theme_title'] }}</span>
            </h1>
            <p class="wizard-subtitle">
                {{ $wizardConfig['theme_subtitle'] }}
            </p>
        </div>

        <!-- 4-Stage Stepper Navigation -->
        <div class="progress-stepper">
            <div class="stepper-track">
                <div class="stepper-progress-fill" id="stepperFill" style="width: 0%;"></div>

                <div class="step-node active" id="node1" onclick="goToStage(1)">
                    <div class="node-bubble" id="bubble1">1</div>
                    <div class="node-label">1. Ceremony Setup</div>
                    <div class="node-subtext">Host, Date & Session</div>
                </div>

                <div class="step-node" id="node2" onclick="goToStage(2)">
                    <div class="node-bubble" id="bubble2">2</div>
                    <div class="node-label">2. Venue & Dining</div>
                    <div class="node-subtext">Hall, Style & Banquet</div>
                </div>

                <div class="step-node" id="node3" onclick="goToStage(3)">
                    <div class="node-bubble" id="bubble3">3</div>
                    <div class="node-label">3. Certified Artisans</div>
                    <div class="node-subtext">Specialized Services</div>
                </div>

                <div class="step-node" id="node4" onclick="goToStage(4)">
                    <div class="node-bubble" id="bubble4">4</div>
                    <div class="node-label">4. Dossier & Lock</div>
                    <div class="node-subtext">Review & Investment</div>
                </div>
            </div>
        </div>

        <!-- Main Form & Telemetry Grid -->
        <form id="wizardBookingForm" method="POST" action="{{ route('booking.store') }}">
            @csrf
            <input type="hidden" name="EventType" value="{{ $categoryName }}">

            <div class="wizard-grid">
                <!-- Left: Interactive Stage Container -->
                <div class="stage-card">

                    {{-- =========================================================================
                         STAGE 1: CEREMONY FUNDAMENTALS (Couple, Auspicious Date & Session)
                    ========================================================================= --}}
                    <div class="stage-pane active" id="stagePane1">
                        <div class="pane-header">
                            <span class="pane-step-tag">Stage 1 of 4</span>
                            <h2 class="pane-title">Event Fundamentals & Auspicious Schedule</h2>
                            <p class="pane-desc">Begin your bespoke reservation by establishing your host profile, auspicious celebration date, timing session, and expected guest headcount.</p>
                        </div>

                        <!-- Logged-in Buyer Verification Chip -->
                        <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: var(--radius-sm); padding: 12px 18px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-user-shield" style="font-size: 20px; color: var(--accent);"></i>
                                <div>
                                    <div style="font-size: 11px; font-weight: 700; color: var(--text-dim); text-transform: uppercase;">Verified Buyer Account</div>
                                    <div style="font-weight: 800; font-size: 14px; color: #fff;">{{ Auth::user()->fullname ?? Auth::user()->username }} ({{ Auth::user()->email }})</div>
                                </div>
                            </div>
                            <span style="font-size: 11px; font-weight: 800; color: #34d399; background: rgba(16, 185, 129, 0.15); padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(16, 185, 129, 0.3);">
                                Authenticated
                            </span>
                        </div>

                        <!-- Celebrants / Host Names -->
                        <div class="form-group">
                            <label class="form-label" for="couple_names">
                                <span>{{ $wizardConfig['host_label'] }} <span style="color:#ef4444;">*</span></span>
                                <small style="color: var(--text-dim); font-weight: normal;">Featured on Itinerary Dossier</small>
                            </label>
                            <input type="text" id="couple_names" name="couple_names" class="glass-input" 
                                   placeholder="{{ $wizardConfig['host_placeholder'] }}"
                                   value="{{ old('couple_names', Auth::user()->fullname ?? Auth::user()->username) }}" required>
                        </div>

                        <!-- Contact Phone & Email -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 22px;">
                            <div>
                                <label class="form-label" for="contact_phone">
                                    <span>Primary Phone <span style="color:#ef4444;">*</span></span>
                                    <small style="color: var(--text-dim);">SMS Updates</small>
                                </label>
                                <input type="tel" id="contact_phone" name="contact_phone" class="glass-input" 
                                       placeholder="+94 77 123 4567"
                                       value="{{ old('contact_phone', '+94 77 269 4820') }}" required>
                            </div>
                            <div>
                                <label class="form-label" for="contact_email">
                                    <span>Primary Email <span style="color:#ef4444;">*</span></span>
                                    <small style="color: var(--text-dim);">PDF Dispatch</small>
                                </label>
                                <input type="email" id="contact_email" name="contact_email" class="glass-input" 
                                       placeholder="client@eventflare.com"
                                       value="{{ old('contact_email', Auth::user()->email) }}" required>
                            </div>
                        </div>

                        <!-- Auspicious Celebration Date -->
                        <div class="form-group">
                            <label class="form-label" for="event_date">
                                <span>{{ $wizardConfig['date_label'] }} <span style="color:#ef4444;">*</span></span>
                                <small style="color: var(--text-dim);"><i class="fas fa-calendar-check"></i> Live Availability</small>
                            </label>
                            <input type="date" id="event_date" name="EventDate" class="glass-input" 
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('EventDate', date('Y-m-d', strtotime('+45 days'))) }}" required>
                        </div>

                        <!-- Session Timing (Day vs Night Cards) -->
                        <div class="form-group">
                            <label class="form-label">
                                <span>Session Timing & Ambiance <span style="color:#ef4444;">*</span></span>
                                <small style="color: var(--text-dim);">Lighting & Kitchen Schedule</small>
                            </label>
                            <div class="selection-grid-2">
                                <div class="option-card {{ old('DayNight', 'Night') === 'Day' ? 'selected' : '' }}" 
                                     id="sessionCardDay" onclick="selectDayNight('Day', this)">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-size: 15px; font-weight: 800; color: #fff;">
                                            <i class="fas fa-sun" style="color: #f59e0b; margin-right: 8px;"></i> {{ $wizardConfig['session_day_title'] }}
                                        </span>
                                        <input type="radio" name="DayNight" value="Day" id="radioDay" {{ old('DayNight') === 'Day' ? 'checked' : '' }} style="display: none;">
                                        <span class="venue-check"><i class="fas fa-check-circle"></i></span>
                                    </div>
                                    <p style="font-size: 12px; color: var(--text-dim); margin: 0; line-height: 1.4;">
                                        {{ $wizardConfig['session_day_desc'] }}
                                    </p>
                                </div>

                                <div class="option-card {{ old('DayNight', 'Night') === 'Night' ? 'selected' : '' }}" 
                                     id="sessionCardNight" onclick="selectDayNight('Night', this)">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-size: 15px; font-weight: 800; color: #fff;">
                                            <i class="fas fa-moon" style="color: #a855f7; margin-right: 8px;"></i> {{ $wizardConfig['session_night_title'] }}
                                        </span>
                                        <input type="radio" name="DayNight" value="Night" id="radioNight" {{ old('DayNight', 'Night') === 'Night' ? 'checked' : '' }} style="display: none;">
                                        <span class="venue-check"><i class="fas fa-check-circle"></i></span>
                                    </div>
                                    <p style="font-size: 12px; color: var(--text-dim); margin: 0; line-height: 1.4;">
                                        {{ $wizardConfig['session_night_desc'] }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Synchronized Guest Headcount -->
                        <div class="form-group">
                            <label class="form-label" for="guests_input">
                                <span>Guest Headcount & Seating Capacity <span style="color:#ef4444;">*</span></span>
                                <small style="color: var(--text-dim);">Live Per-Head Math Active</small>
                            </label>
                            <div class="slider-container">
                                <div class="slider-metrics">
                                    <div class="slider-value-display">
                                        <span id="guestCountDisplay">{{ old('NumberOfGuests', $preGuests > 0 ? $preGuests : $wizardConfig['guest_default']) }}</span>
                                        <small>Attendees</small>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-size: 12px; color: var(--text-dim);">Manual input:</span>
                                        <input type="number" id="guests_input" name="NumberOfGuests" 
                                               class="glass-input" style="width: 100px; padding: 6px 12px; text-align: center; font-weight: 800;"
                                               min="{{ $wizardConfig['guest_min'] }}" max="{{ $wizardConfig['guest_max'] }}" 
                                               value="{{ old('NumberOfGuests', $preGuests > 0 ? $preGuests : $wizardConfig['guest_default']) }}"
                                               oninput="syncSliderFromInput(this.value)" required>
                                    </div>
                                </div>
                                <input type="range" id="guestRange" class="custom-range" 
                                       min="{{ $wizardConfig['guest_min'] }}" max="{{ $wizardConfig['guest_max'] }}" step="5"
                                       value="{{ old('NumberOfGuests', $preGuests > 0 ? $preGuests : $wizardConfig['guest_default']) }}"
                                       oninput="syncInputFromSlider(this.value)">
                                <div style="display: flex; justify-content: space-between; font-size: 11px; color: var(--text-dim); margin-top: 8px;">
                                    <span>{{ $wizardConfig['guest_min'] }} Pax</span>
                                    <span>{{ (int)(($wizardConfig['guest_min'] + $wizardConfig['guest_max']) / 2) }} Pax</span>
                                    <span>{{ $wizardConfig['guest_max'] }}+ Pax</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stage 1 Footer Actions -->
                        <div style="display: flex; justify-content: flex-end; margin-top: 32px;">
                            <button type="button" class="btn-step-next" onclick="validateAndGoStage(2)">
                                <span>Proceed to Venue & Style Selection</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- =========================================================================
                         STAGE 2: VENUE, THEMATIC STYLE & CATERING TIER (STRICT SEQUENCE)
                         1. Hall / Destination Venue
                         2. Aesthetic & Thematic Style
                         3. Curated Catering / Dining Tier
                    ========================================================================= --}}
                    <div class="stage-pane" id="stagePane2">
                        <div class="pane-header">
                            <span class="pane-step-tag">Stage 2 of 4</span>
                            <h2 class="pane-title">Venue Setting, Thematic Style & Dining Tiers</h2>
                            <p class="pane-desc">Select your signature destination venue, choose your aesthetic theme, and configure your gourmet dining tier with live per-head calculation.</p>
                        </div>

                        <!-- 1. HALL / DESTINATION VENUE -->
                        <div class="form-group" style="margin-bottom: 36px;">
                            <label class="form-label">
                                <span style="font-size: 15px; font-weight: 800; color: #fff;">
                                    <i class="fas fa-hotel" style="color: var(--accent); margin-right: 6px;"></i>
                                    1. Hall / Destination Venue <span style="color:#ef4444;">*</span>
                                </span>
                                <small style="color: var(--text-dim);">Select a signature venue or type custom below</small>
                            </label>

                            <div class="venues-grid">
                                @foreach($wizardConfig['venues'] as $idx => $v)
                                    @php
                                        $isSelectedVenue = (strcasecmp($preVenue, $v['name']) === 0 || (empty($preVenue) && $idx === 0));
                                    @endphp
                                    <div class="venue-card {{ $isSelectedVenue ? 'selected' : '' }}" 
                                         onclick="selectVenueCard(this, '{{ addslashes($v['name']) }}')">
                                        <div class="venue-card-header">
                                            <div class="venue-name">
                                                <i class="{{ $v['icon'] }}"></i> {{ $v['name'] }}
                                            </div>
                                            <span class="venue-badge">{{ $v['capacity'] }}</span>
                                        </div>
                                        <div class="venue-desc">
                                            {{ $v['tag'] }}
                                        </div>
                                        <div class="venue-footer">
                                            <span class="venue-loc"><i class="fas fa-map-marker-alt"></i> {{ $v['city'] }}</span>
                                            <span class="venue-check"><i class="fas fa-check-circle"></i></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Confirmed Venue Text Input -->
                            <div class="venue-input-container">
                                <label class="form-label" for="place">
                                    <span>
                                        <i class="fas fa-check-circle" style="color: var(--accent); margin-right: 6px;"></i>
                                        Confirmed Destination Venue / Custom Hall Address <span style="color:#ef4444;">*</span>
                                    </span>
                                    <small style="color: var(--text-dim);">Editable for any bespoke location</small>
                                </label>
                                <input type="text" id="place" name="Place" class="glass-input" 
                                       placeholder="e.g. Shangri-La Colombo, Kingsbury Ballroom, or Private Residence"
                                       value="{{ old('Place', $preVenue ?: $wizardConfig['venues'][0]['name']) }}" 
                                       oninput="onCustomVenueInput()" required>
                            </div>
                        </div>

                        <!-- 2. AESTHETIC & THEMATIC STYLE -->
                        <div class="form-group" style="margin-bottom: 36px;">
                            <label class="form-label">
                                <span style="font-size: 15px; font-weight: 800; color: #fff;">
                                    <i class="fas fa-palette" style="color: var(--accent); margin-right: 6px;"></i>
                                    2. Aesthetic & Thematic Style <span style="color:#ef4444;">*</span>
                                </span>
                                <small style="color: var(--text-dim);">Drives staging & ambient lighting</small>
                            </label>

                            <div class="selection-grid-2">
                                @foreach($wizardConfig['styles'] as $key => $style)
                                    @php
                                        $isSelectedStyle = (strcasecmp($preStyle, $key) === 0 || (empty($preStyle) && $loop->first));
                                    @endphp
                                    <div class="option-card {{ $isSelectedStyle ? 'selected' : '' }}" 
                                         onclick="selectStyle('{{ $key }}', this)">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <span style="font-size: 16px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px;">
                                                <i class="{{ $style['icon'] }}" style="color: {{ $style['color'] }}; font-size: 18px;"></i>
                                                {{ $style['title'] }}
                                            </span>
                                            <input type="radio" name="cultural_style" value="{{ $key }}" {{ $isSelectedStyle ? 'checked' : '' }} style="display: none;">
                                            <span class="venue-check"><i class="fas fa-check-circle"></i></span>
                                        </div>
                                        <p style="font-size: 12px; color: var(--text-dim); margin: 0; line-height: 1.45;">
                                            {{ $style['desc'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- 3. CURATED CATERING / DINING TIER (PER HEAD RATE) -->
                        <div class="form-group">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <label class="form-label" style="margin: 0;">
                                    <span style="font-size: 15px; font-weight: 800; color: #fff;">
                                        <i class="fas fa-utensils" style="color: var(--accent); margin-right: 6px;"></i>
                                        3. Curated Catering Tier (Per Head Rate) <span style="color:#ef4444;">*</span>
                                    </span>
                                </label>
                                <a href="{{ route('food-calculator') }}" target="_blank" 
                                   style="font-size: 12px; color: var(--badge-accent); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-calculator"></i> Food Calculator Assistant
                                </a>
                            </div>

                            <div class="selection-grid-3">
                                @foreach($wizardConfig['catering_tiers'] as $tierKey => $tier)
                                    @php
                                        $isSelectedTier = ($loop->first);
                                    @endphp
                                    <div class="option-card {{ $isSelectedTier ? 'selected' : '' }}" 
                                         onclick="selectCateringTier('{{ $tierKey }}', {{ $tier['rate'] }}, this)">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                            <span style="font-size: 10px; font-weight: 800; color: var(--accent); text-transform: uppercase; letter-spacing: 0.5px;">
                                                {{ $tier['badge'] }}
                                            </span>
                                            <input type="radio" name="catering_tier" value="{{ $tierKey }}" {{ $isSelectedTier ? 'checked' : '' }} style="display: none;">
                                            <span class="venue-check"><i class="fas fa-check-circle"></i></span>
                                        </div>
                                        <h4 style="font-size: 16px; font-weight: 900; color: #fff; margin: 0 0 4px;">{{ $tier['name'] }}</h4>
                                        <div style="font-size: 20px; font-weight: 900; color: var(--badge-accent); margin-bottom: 8px;">
                                            LKR {{ number_format($tier['rate']) }} <small style="font-size: 11px; font-weight: 600; color: var(--text-dim);">/ head</small>
                                        </div>
                                        <p style="font-size: 12px; color: #cbd5e1; line-height: 1.4; margin-bottom: 12px;">
                                            {{ $tier['tagline'] }}
                                        </p>
                                        <ul style="list-style: none; padding: 0; margin: 0; font-size: 11px; color: var(--text-dim); display: flex; flex-direction: column; gap: 6px;">
                                            @foreach($tier['highlights'] as $item)
                                                <li style="display: flex; align-items: flex-start; gap: 6px;">
                                                    <i class="fas fa-check" style="color: #10b981; font-size: 10px; margin-top: 2px;"></i>
                                                    <span>{{ $item }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Stage 2 Footer Actions -->
                        <div style="display: flex; justify-content: space-between; margin-top: 36px;">
                            <button type="button" class="btn-step-prev" onclick="goToStage(1)">
                                <i class="fas fa-arrow-left"></i>
                                <span>Back to Step 1</span>
                            </button>
                            <button type="button" class="btn-step-next" onclick="validateAndGoStage(3)">
                                <span>Proceed to Certified Artisans</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- =========================================================================
                         STAGE 3: CERTIFIED ARTISANS & SERVICE PACKAGES
                    ========================================================================= --}}
                    <div class="stage-pane" id="stagePane3">
                        <div class="pane-header">
                            <span class="pane-step-tag">Stage 3 of 4</span>
                            <h2 class="pane-title">Accredited Artisans & Production Packages</h2>
                            <p class="pane-desc">Handpick vetted professionals, audio-visual rigging, cultural troupes, and specialized artisans. Each package calculates in real-time on your investment telemetry.</p>
                        </div>

                        @if($services->isNotEmpty())
                            @foreach($services as $srv)
                                @if($srv->listings->isNotEmpty())
                                    <div class="service-block">
                                        <div class="service-header">
                                            <div class="service-title">
                                                <i class="fas fa-award"></i>
                                                <span>{{ $srv->service_name }}</span>
                                            </div>
                                            <span style="font-size: 11px; color: var(--text-dim);">{{ $srv->listings->count() }} Available Packages</span>
                                        </div>
                                        <p style="font-size: 12px; color: var(--text-dim); margin-bottom: 14px; line-height: 1.4;">
                                            {{ $srv->description ?? $srv->notes }}
                                        </p>

                                        <div class="package-option-grid">
                                            @foreach($srv->listings as $pkg)
                                                <div class="package-card" onclick="selectPackageCard('{{ $srv->service_id }}', '{{ $pkg->listing_id }}', {{ $pkg->price }}, '{{ $pkg->price_type }}', '{{ addslashes($pkg->title) }}', this)">
                                                    <div class="package-card-top">
                                                        <img src="{{ $pkg->supplier->logo_url ?? 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=80' }}" 
                                                             class="pkg-supplier-thumb" alt="Supplier Logo">
                                                        <div>
                                                            <div class="pkg-supplier-name">{{ $pkg->supplier->business_name }}</div>
                                                            <div class="pkg-title">{{ $pkg->title }}</div>
                                                        </div>
                                                    </div>
                                                    <p style="font-size: 11px; color: var(--text-dim); margin: 0 0 10px; line-height: 1.35;">
                                                        {{ Str::limit($pkg->description, 90) }}
                                                    </p>
                                                    <div class="pkg-price-tag">
                                                        <div class="pkg-amount">
                                                            LKR {{ number_format($pkg->price) }}
                                                        </div>
                                                        <span class="pkg-type-badge">
                                                            {{ $pkg->price_type === 'per_person' ? 'Per Attendee' : 'Flat Fee' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Omit Option -->
                                            <div class="package-card selected" onclick="omitPackage('{{ $srv->service_id }}', this)">
                                                <div style="display: flex; align-items: center; justify-content: space-between; height: 100%; min-height: 110px;">
                                                    <div>
                                                        <div style="font-size: 13px; font-weight: 800; color: #fff;">Omit Optional Service</div>
                                                        <div style="font-size: 11px; color: var(--text-dim); margin-top: 4px;">Handle internally or select later</div>
                                                    </div>
                                                    <span class="venue-check"><i class="fas fa-check-circle"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden Inputs Container for this Service -->
                                        <input type="hidden" name="selected_packages[{{ $srv->service_id }}]" id="serviceInput_{{ $srv->service_id }}" value="">
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 40px; background: rgba(255, 255, 255, 0.02); border-radius: var(--radius-md); border: 1px dashed rgba(255, 255, 255, 0.1);">
                                <i class="fas fa-box-open" style="font-size: 36px; color: var(--text-dim); margin-bottom: 12px;"></i>
                                <h4 style="font-size: 16px; color: #fff; margin-bottom: 6px;">Direct Coordination Service</h4>
                                <p style="font-size: 13px; color: var(--text-dim); max-width: 450px; margin: 0 auto;">
                                    All specialized production and suppliers for {{ $categoryName }} will be coordinated directly by our dedicated concierge team.
                                </p>
                            </div>
                        @endif

                        <!-- Staging & AV Production Customizations -->
                        <div class="form-group" style="margin-top: 28px;">
                            <label class="form-label" for="equipment">
                                <span>{{ $wizardConfig['equipment_label'] }}</span>
                                <small style="color: var(--text-dim);">Audio / Lighting / Decor</small>
                            </label>
                            <input type="text" id="equipment" name="equipment" class="glass-input" 
                                   placeholder="{{ $wizardConfig['equipment_placeholder'] }}"
                                   value="{{ old('equipment') }}">
                        </div>

                        <!-- Stage 3 Footer Actions -->
                        <div style="display: flex; justify-content: space-between; margin-top: 36px;">
                            <button type="button" class="btn-step-prev" onclick="goToStage(2)">
                                <i class="fas fa-arrow-left"></i>
                                <span>Back to Step 2</span>
                            </button>
                            <button type="button" class="btn-step-next" onclick="validateAndGoStage(4)">
                                <span>Proceed to Dossier Review</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- =========================================================================
                         STAGE 4: COMPREHENSIVE DOSSIER REVIEW & FINAL LOCK
                    ========================================================================= --}}
                    <div class="stage-pane" id="stagePane4">
                        <div class="pane-header">
                            <span class="pane-step-tag">Stage 4 of 4</span>
                            <h2 class="pane-title">Dossier Review & Final Reservation Lock</h2>
                            <p class="pane-desc">Review your complete event dossier. Once confirmed, our atomic transaction engine reserves your date and generates your formal PDF itinerary.</p>
                        </div>

                        <!-- 1. Celebrants & Contact Profile -->
                        <div class="dossier-review-card">
                            <div class="dossier-section-title">
                                <i class="fas fa-user-check"></i>
                                <span>1. Host / Celebrant & Contact Profile</span>
                            </div>
                            <div class="dossier-grid-summary">
                                <div class="dossier-row">
                                    <span class="dossier-label">{{ $wizardConfig['host_label'] }}</span>
                                    <span class="dossier-val" id="reviewCelebrants">—</span>
                                </div>
                                <div class="dossier-row">
                                    <span class="dossier-label">Primary Phone</span>
                                    <span class="dossier-val" id="reviewPhone">—</span>
                                </div>
                                <div class="dossier-row">
                                    <span class="dossier-label">Primary Email</span>
                                    <span class="dossier-val" id="reviewEmail">—</span>
                                </div>
                                <div class="dossier-row">
                                    <span class="dossier-label">Buyer Account</span>
                                    <span class="dossier-val">{{ Auth::user()->fullname ?? Auth::user()->username }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Logistics, Date & Venue Setting -->
                        <div class="dossier-review-card">
                            <div class="dossier-section-title">
                                <i class="fas fa-map-marked-alt"></i>
                                <span>2. Logistics, Date & Venue Setting</span>
                            </div>
                            <div class="dossier-grid-summary">
                                <div class="dossier-row">
                                    <span class="dossier-label">Celebration Date</span>
                                    <span class="dossier-val" id="reviewDate">—</span>
                                </div>
                                <div class="dossier-row">
                                    <span class="dossier-label">Session Timing</span>
                                    <span class="dossier-val" id="reviewSession">—</span>
                                </div>
                                <div class="dossier-row">
                                    <span class="dossier-label">Destination Venue / Hall</span>
                                    <span class="dossier-val" id="reviewVenue">—</span>
                                </div>
                                <div class="dossier-row">
                                    <span class="dossier-label">Guest Headcount</span>
                                    <span class="dossier-val" id="reviewGuests">—</span>
                                </div>
                                <div class="dossier-row" style="grid-column: span 2;">
                                    <span class="dossier-label">Aesthetic & Thematic Style</span>
                                    <span class="dossier-val" id="reviewStyle">—</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Gourmet Dining & Catering Specifications -->
                        <div class="dossier-review-card">
                            <div class="dossier-section-title">
                                <i class="fas fa-utensils"></i>
                                <span>3. Gourmet Dining & Catering Specifications</span>
                            </div>
                            <div class="dossier-grid-summary">
                                <div class="dossier-row">
                                    <span class="dossier-label">Catering Tier</span>
                                    <span class="dossier-val" id="reviewCateringTier">—</span>
                                </div>
                                <div class="dossier-row">
                                    <span class="dossier-label">Per Head Rate</span>
                                    <span class="dossier-val" id="reviewCateringRate">—</span>
                                </div>
                                <div class="dossier-row" style="grid-column: span 2;">
                                    <span class="dossier-label">Base Dining Subtotal</span>
                                    <span class="dossier-val" id="reviewCateringSubtotal" style="color: var(--accent); font-size: 16px;">—</span>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Accredited Artisans & Stage Production -->
                        <div class="dossier-review-card">
                            <div class="dossier-section-title">
                                <i class="fas fa-award"></i>
                                <span>4. Accredited Artisans & Stage Production</span>
                            </div>
                            <table class="dossier-table">
                                <thead>
                                    <tr>
                                        <th>Service Category</th>
                                        <th>Selected Artisan / Package</th>
                                        <th>Fee Type</th>
                                        <th style="text-align: right;">Amount (LKR)</th>
                                    </tr>
                                </thead>
                                <tbody id="reviewArtisansTable">
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: var(--text-dim);">No artisan add-ons selected.</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div style="margin-top: 16px; padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.06);">
                                <span class="dossier-label">Stage & AV Production Needs:</span>
                                <p id="reviewEquipment" style="font-size: 13px; color: #fff; font-weight: 700; margin: 4px 0 0;">None specified</p>
                            </div>
                        </div>

                        <!-- 5. Timeline Coordination & Special Notes -->
                        <div class="form-group">
                            <label class="form-label" for="extra_details">
                                <span class="dossier-section-title" style="margin: 0; padding: 0; border: none;">
                                    <i class="fas fa-clipboard-list"></i>
                                    <span>5. Special Notes, Timeline & Dietary Directives</span>
                                </span>
                            </label>
                            <textarea id="extra_details" name="ExtraDetails" class="glass-input" 
                                      style="height: 100px; resize: vertical;"
                                      placeholder="{{ $wizardConfig['notes_placeholder'] }}">{{ old('ExtraDetails', $preDetails) }}</textarea>
                        </div>

                        <!-- 6. Consolidated Financial Investment Ledger -->
                        <div class="dossier-review-card" style="border-color: var(--active-border); background: var(--surface-glass-active);">
                            <div class="dossier-section-title" style="border-color: rgba(255, 255, 255, 0.15);">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span>6. Consolidated Financial Investment Ledger</span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <div style="display: flex; justify-content: space-between; font-size: 13px; color: #cbd5e1;">
                                    <span>Catering & Dining Base:</span>
                                    <strong id="ledgerCateringBase" style="color: #fff;">LKR 0</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 13px; color: #cbd5e1;">
                                    <span>Artisans & Production Subtotal:</span>
                                    <strong id="ledgerArtisansTotal" style="color: #fff;">LKR 0</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 900; color: #fff; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.15);">
                                    <span>Estimated Grand Investment:</span>
                                    <span id="ledgerGrandTotal" style="color: var(--accent);">LKR 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Security & Transaction Assurance Guarantee -->
                        <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: var(--radius-sm); padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 14px;">
                            <i class="fas fa-shield-alt" style="font-size: 24px; color: #34d399;"></i>
                            <div style="font-size: 12px; color: #cbd5e1; line-height: 1.4;">
                                <strong style="color: #34d399; display: block; margin-bottom: 2px;">MySQL Atomic Transaction & Instant PDF Guarantee</strong>
                                Your reservation is securely locked across our supplier grid. An official itinerary dossier will be generated for instant download.
                            </div>
                        </div>

                        <!-- Stage 4 Footer Actions -->
                        <div style="display: flex; justify-content: space-between; margin-top: 36px;">
                            <button type="button" class="btn-step-prev" onclick="goToStage(3)">
                                <i class="fas fa-arrow-left"></i>
                                <span>Back to Step 3</span>
                            </button>
                            <button type="submit" class="btn-step-next" style="background: linear-gradient(135deg, #10b981, #059669); color: #fff; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);">
                                <i class="fas fa-lock"></i>
                                <span>Confirm & Lock Event Reservation</span>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Right: Sticky Live Telemetry Sidebar -->
                <div class="telemetry-card">
                    <div class="telemetry-header">
                        <div class="telemetry-title">
                            <i class="fas fa-bolt" style="color: var(--accent);"></i>
                            <span>Live Investment Telemetry</span>
                        </div>
                        <div class="telemetry-pulse"></div>
                    </div>

                    <div style="margin-bottom: 18px;">
                        <div style="font-size: 11px; font-weight: 700; color: var(--text-dim); text-transform: uppercase;">Selected Category</div>
                        <div style="font-size: 16px; font-weight: 900; color: #fff; margin-top: 2px;">{{ $categoryName }}</div>
                    </div>

                    <div class="telemetry-item">
                        <span>Guest Headcount:</span>
                        <strong id="sideGuests">{{ old('NumberOfGuests', $preGuests > 0 ? $preGuests : $wizardConfig['guest_default']) }} Attendees</strong>
                    </div>

                    <div class="telemetry-item">
                        <span>Catering Tier Rate:</span>
                        <strong id="sideTierRate">LKR 0</strong>
                    </div>

                    <div class="telemetry-item">
                        <span>Catering Subtotal:</span>
                        <strong id="sideCateringSubtotal">LKR 0</strong>
                    </div>

                    <div class="telemetry-item">
                        <span>Selected Artisans:</span>
                        <strong id="sideArtisansCount">0 Services</strong>
                    </div>

                    <div class="telemetry-item">
                        <span>Artisans Subtotal:</span>
                        <strong id="sideArtisansSubtotal">LKR 0</strong>
                    </div>

                    <div class="telemetry-total-box">
                        <div class="total-label">Estimated Grand Total</div>
                        <div class="total-amount" id="sideGrandTotal">LKR 0</div>
                        <div style="font-size: 11px; color: var(--text-dim);">Accredited Sri Lankan Rates (LKR)</div>
                    </div>

                    <!-- Trust Pillars -->
                    <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid rgba(255, 255, 255, 0.08); display: flex; flex-direction: column; gap: 10px; font-size: 12px; color: var(--text-dim);">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #10b981;"></i>
                            <span>100% Accredited & Vetted Suppliers</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #10b981;"></i>
                            <span>Instant Itinerary PDF Dossier</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #10b981;"></i>
                            <span>Transparent Sri Lankan Rupee Pricing</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // State Variables
    let currentStage = 1;
    let selectedTierRate = {{ array_values($wizardConfig['catering_tiers'])[0]['rate'] ?? 6500 }};
    let selectedTierName = '{{ array_key_first($wizardConfig['catering_tiers']) ?? "Platinum" }}';
    let selectedPackages = {}; // serviceId => { listingId, price, priceType, title }

    document.addEventListener('DOMContentLoaded', () => {
        recalculateInvestment();
    });

    // Step Navigation & Validation
    function goToStage(stageNum) {
        if (stageNum > currentStage) {
            validateAndGoStage(stageNum);
        } else {
            activateStage(stageNum);
        }
    }

    function validateAndGoStage(targetStage) {
        if (targetStage === 2) {
            const celebrants = document.getElementById('couple_names').value.trim();
            const phone = document.getElementById('contact_phone').value.trim();
            const email = document.getElementById('contact_email').value.trim();
            const date = document.getElementById('event_date').value.trim();

            if (!celebrants || !phone || !email || !date) {
                alert('Please fill in all required contact, celebrant, and date fields before proceeding.');
                return;
            }
        }

        if (targetStage === 3) {
            const place = document.getElementById('place').value.trim();
            if (!place) {
                alert('Please select or specify a destination venue / hall location.');
                document.getElementById('place').focus();
                return;
            }
        }

        if (targetStage === 4) {
            syncDossierReview();
        }

        activateStage(targetStage);
    }

    function activateStage(stageNum) {
        currentStage = stageNum;

        // Update Panes
        document.querySelectorAll('.stage-pane').forEach((pane, idx) => {
            pane.classList.toggle('active', (idx + 1) === stageNum);
        });

        // Update Stepper Nodes
        for (let i = 1; i <= 4; i++) {
            const node = document.getElementById('node' + i);
            const bubble = document.getElementById('bubble' + i);

            node.classList.remove('active', 'completed');
            if (i < stageNum) {
                node.classList.add('completed');
                bubble.innerHTML = '<i class="fas fa-check"></i>';
            } else if (i === stageNum) {
                node.classList.add('active');
                bubble.innerHTML = i;
            } else {
                bubble.innerHTML = i;
            }
        }

        // Stepper Progress Line Fill
        const fillWidth = ((stageNum - 1) / 3) * 76;
        document.getElementById('stepperFill').style.width = fillWidth + '%';

        window.scrollTo({ top: 180, behavior: 'smooth' });
    }

    // Stage 1 Synchronized Headcount
    function syncInputFromSlider(val) {
        document.getElementById('guests_input').value = val;
        document.getElementById('guestCountDisplay').innerText = val;
        recalculateInvestment();
    }

    function syncSliderFromInput(val) {
        const num = parseInt(val) || {{ $wizardConfig['guest_min'] }};
        document.getElementById('guestRange').value = num;
        document.getElementById('guestCountDisplay').innerText = num;
        recalculateInvestment();
    }

    function selectDayNight(session, el) {
        document.getElementById('radioDay').checked = (session === 'Day');
        document.getElementById('radioNight').checked = (session === 'Night');

        document.getElementById('sessionCardDay').classList.toggle('selected', session === 'Day');
        document.getElementById('sessionCardNight').classList.toggle('selected', session === 'Night');
    }

    // Stage 2 Venue Selection & Custom Input Sync
    function selectVenueCard(el, venueName) {
        document.querySelectorAll('.venue-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');

        const placeInput = document.getElementById('place');
        if (placeInput) {
            placeInput.value = venueName;
        }
        recalculateInvestment();
    }

    function onCustomVenueInput() {
        const customVal = document.getElementById('place').value.trim().toLowerCase();
        let matched = false;

        document.querySelectorAll('.venue-card').forEach(c => {
            const vNameEl = c.querySelector('.venue-name');
            const vName = vNameEl ? vNameEl.innerText.trim().toLowerCase() : '';
            if (vName && vName === customVal) {
                c.classList.add('selected');
                matched = true;
            } else {
                c.classList.remove('selected');
            }
        });

        if (!matched) {
            // Select Bespoke card if available
            document.querySelectorAll('.venue-card').forEach(c => {
                const vNameEl = c.querySelector('.venue-name');
                if (vNameEl && vNameEl.innerText.toLowerCase().includes('bespoke')) {
                    c.classList.add('selected');
                }
            });
        }
    }

    // Stage 2 Style & Catering Selection
    function selectStyle(styleKey, el) {
        document.querySelectorAll('input[name="cultural_style"]').forEach(radio => {
            radio.checked = (radio.value === styleKey);
        });
        el.parentElement.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
    }

    function selectCateringTier(tierKey, rate, el) {
        selectedTierName = tierKey;
        selectedTierRate = rate;

        document.querySelectorAll('input[name="catering_tier"]').forEach(radio => {
            radio.checked = (radio.value === tierKey);
        });
        el.parentElement.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');

        recalculateInvestment();
    }

    // Stage 3 Package Selection
    function selectPackageCard(serviceId, listingId, price, priceType, title, el) {
        selectedPackages[serviceId] = {
            listingId: listingId,
            price: parseFloat(price),
            priceType: priceType,
            title: title
        };

        document.getElementById('serviceInput_' + serviceId).value = listingId;

        const grid = el.closest('.package-option-grid');
        grid.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');

        recalculateInvestment();
    }

    function omitPackage(serviceId, el) {
        delete selectedPackages[serviceId];
        document.getElementById('serviceInput_' + serviceId).value = '';

        const grid = el.closest('.package-option-grid');
        grid.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');

        recalculateInvestment();
    }

    // Real-Time Investment Calculation Engine
    function recalculateInvestment() {
        const guests = parseInt(document.getElementById('guests_input').value) || {{ $wizardConfig['guest_min'] }};
        const cateringSubtotal = guests * selectedTierRate;

        let artisansSubtotal = 0;
        let count = 0;

        for (const sId in selectedPackages) {
            const pkg = selectedPackages[sId];
            count++;
            if (pkg.priceType === 'per_person') {
                artisansSubtotal += (pkg.price * guests);
            } else {
                artisansSubtotal += pkg.price;
            }
        }

        const grandTotal = cateringSubtotal + artisansSubtotal;

        // Format to LKR string
        const fmt = num => 'LKR ' + Math.round(num).toLocaleString();

        // Update Sidebar Telemetry
        document.getElementById('sideGuests').innerText = guests + ' Attendees';
        document.getElementById('sideTierRate').innerText = fmt(selectedTierRate) + ' / head';
        document.getElementById('sideCateringSubtotal').innerText = fmt(cateringSubtotal);
        document.getElementById('sideArtisansCount').innerText = count + ' Services';
        document.getElementById('sideArtisansSubtotal').innerText = fmt(artisansSubtotal);
        document.getElementById('sideGrandTotal').innerText = fmt(grandTotal);

        // Update Dossier Ledger if rendered
        const lCat = document.getElementById('ledgerCateringBase');
        const lArt = document.getElementById('ledgerArtisansTotal');
        const lGrd = document.getElementById('ledgerGrandTotal');

        if (lCat) lCat.innerText = fmt(cateringSubtotal);
        if (lArt) lArt.innerText = fmt(artisansSubtotal);
        if (lGrd) lGrd.innerText = fmt(grandTotal);

        const rCatRate = document.getElementById('reviewCateringRate');
        const rCatSub = document.getElementById('reviewCateringSubtotal');
        if (rCatRate) rCatRate.innerText = fmt(selectedTierRate) + ' / head';
        if (rCatSub) rCatSub.innerText = fmt(cateringSubtotal) + ' (' + guests + ' pax)';
    }

    // Stage 4 Comprehensive Dossier Population
    function syncDossierReview() {
        const celebrants = document.getElementById('couple_names').value.trim();
        const phone = document.getElementById('contact_phone').value.trim();
        const email = document.getElementById('contact_email').value.trim();
        const date = document.getElementById('event_date').value.trim();
        const venue = document.getElementById('place').value.trim();
        const guests = document.getElementById('guests_input').value.trim();
        const session = document.getElementById('radioDay').checked ? 'Daytime Session' : 'Evening Starlight Session';

        const styleRadio = document.querySelector('input[name="cultural_style"]:checked');
        const style = styleRadio ? styleRadio.value + ' Style' : 'Signature Concept';

        const equip = document.getElementById('equipment').value.trim();

        // Populate Dossier Fields
        document.getElementById('reviewCelebrants').innerText = celebrants || '—';
        document.getElementById('reviewPhone').innerText = phone || '—';
        document.getElementById('reviewEmail').innerText = email || '—';
        document.getElementById('reviewDate').innerText = date || '—';
        document.getElementById('reviewSession').innerText = session;
        document.getElementById('reviewVenue').innerText = venue || '—';
        document.getElementById('reviewGuests').innerText = guests + ' Attendees';
        document.getElementById('reviewStyle').innerText = style;
        document.getElementById('reviewCateringTier').innerText = selectedTierName + ' Tier';
        document.getElementById('reviewEquipment').innerText = equip || 'Standard Production Staging';

        // Render Artisans Table
        const tbody = document.getElementById('reviewArtisansTable');
        tbody.innerHTML = '';
        let hasArtisans = false;

        for (const sId in selectedPackages) {
            hasArtisans = true;
            const pkg = selectedPackages[sId];
            const guestsCount = parseInt(guests) || 1;
            const cost = (pkg.priceType === 'per_person') ? (pkg.price * guestsCount) : pkg.price;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="font-weight: 700; color: #fff;">Service Add-On</td>
                <td>${pkg.title}</td>
                <td><span class="pkg-type-badge">${pkg.priceType === 'per_person' ? 'Per Attendee' : 'Flat Fee'}</span></td>
                <td style="text-align: right; font-weight: 800; color: var(--accent);">LKR ${Math.round(cost).toLocaleString()}</td>
            `;
            tbody.appendChild(tr);
        }

        if (!hasArtisans) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; color: var(--text-dim);">No optional artisan add-ons selected (Default Coordination).</td></tr>';
        }

        recalculateInvestment();
    }
</script>

@endsection
