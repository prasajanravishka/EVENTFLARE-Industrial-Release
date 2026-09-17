@extends('layouts.eventflare')

@php
    $isWedding = (empty($preEvent) || stripos($preEvent, 'Wed') !== false);
@endphp

@section('title', $isWedding ? 'Bespoke Wedding Booking Wizard — EVENTFLARE' : 'Book Your Celebration — EVENTFLARE')

@section('content')

@if($isWedding)
{{-- =========================================================================
     4-STAGE BESPOKE WEDDING BOOKING WIZARD
========================================================================= --}}
<style>
    :root {
        --primary-glow: rgba(139, 92, 246, 0.45);
        --secondary-glow: rgba(236, 72, 153, 0.4);
        --gold: #f59e0b;
        --gold-glow: rgba(245, 158, 11, 0.35);
        --surface-glass: rgba(22, 19, 39, 0.65);
        --surface-glass-card: rgba(27, 23, 49, 0.78);
        --surface-glass-border: rgba(255, 255, 255, 0.12);
        --surface-glass-active: rgba(139, 92, 246, 0.22);
        --text-dim: #64748b;
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
        opacity: 0.5;
        animation: floatOrb 20s ease-in-out infinite alternate;
    }
    .orb-1 {
        width: 480px; height: 480px;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        top: -60px; left: -100px;
    }
    .orb-2 {
        width: 420px; height: 420px;
        background: linear-gradient(135deg, #ec4899, #db2777);
        bottom: 50px; right: -80px;
        animation-duration: 24s;
    }
    .orb-3 {
        width: 320px; height: 320px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        top: 40%; right: 20%;
        opacity: 0.25;
        animation-duration: 28s;
    }

    @keyframes floatOrb {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(50px, 30px) scale(1.06); }
        100% { transform: translate(-30px, 60px) scale(0.96); }
    }

    .wizard-container {
        max-width: 1240px;
        margin: 0 auto;
        position: relative;
        z-index: 10;
    }

    .wizard-header {
        text-align: center;
        margin-bottom: 36px;
    }
    .curated-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(139, 92, 246, 0.15);
        border: 1px solid rgba(139, 92, 246, 0.35);
        color: #c4b5fd;
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 14px;
        box-shadow: 0 0 25px rgba(139, 92, 246, 0.2);
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
        color: var(--text-muted);
        max-width: 680px;
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
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        z-index: 2;
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 12px var(--primary-glow);
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
        background: #19152b; border: 2px solid rgba(255, 255, 255, 0.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 700; color: var(--text-muted);
        margin-bottom: 10px; transition: all 0.4s ease;
    }
    .step-node.active .node-bubble {
        background: linear-gradient(135deg, var(--primary), #6366f1);
        border-color: #c4b5fd; color: #fff;
        transform: scale(1.12);
        box-shadow: 0 0 24px var(--primary-glow);
    }
    .step-node.completed .node-bubble {
        background: linear-gradient(135deg, #10b981, #059669);
        border-color: #6ee7b7; color: #fff;
    }
    .node-label { font-size: 13px; font-weight: 700; color: var(--text-muted); }
    .node-subtext { font-size: 11px; color: var(--text-dim); margin-top: 2px; }
    .step-node.active .node-label { color: #fff; }
    .step-node.completed .node-label { color: #6ee7b7; }

    .wizard-layout {
        display: grid;
        grid-template-columns: 1.4fr 0.9fr;
        gap: 32px;
        align-items: start;
    }
    @media (max-width: 980px) {
        .wizard-layout { grid-template-columns: 1fr; }
        .node-subtext { display: none; }
    }

    .glass-panel {
        background: var(--surface-glass-card);
        border: 1px solid var(--surface-glass-border);
        border-radius: var(--radius-lg);
        padding: 36px;
        box-shadow: var(--shadow-glass);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        position: relative;
    }

    .stage-pane {
        display: none;
        animation: fadeInStage 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .stage-pane.active { display: block; }
    @keyframes fadeInStage {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .stage-legend {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .stage-icon {
        width: 42px; height: 42px; border-radius: 12px;
        background: rgba(139, 92, 246, 0.15); border: 1px solid rgba(139, 92, 246, 0.3);
        display: flex; align-items: center; justify-content: center;
        color: #c4b5fd; font-size: 18px;
    }
    .stage-title { font-size: 22px; font-weight: 800; color: #fff; }
    .stage-desc { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

    .form-group { margin-bottom: 22px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
    .input-label { display: block; font-size: 13px; font-weight: 700; color: #e2e8f0; margin-bottom: 8px; }
    .input-label .req { color: #f43f5e; margin-left: 2px; }
    .input-glass {
        width: 100%;
        background: rgba(15, 12, 27, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: var(--radius-sm);
        padding: 13px 16px;
        color: #fff;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .input-glass:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 16px var(--primary-glow);
        background: rgba(22, 17, 40, 0.9);
    }
    .input-glass::placeholder { color: var(--text-dim); }

    .session-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .session-card {
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(17, 14, 31, 0.6);
        border-radius: var(--radius-md);
        padding: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .session-card.selected {
        border-color: var(--primary);
        background: var(--surface-glass-active);
        box-shadow: 0 0 20px var(--primary-glow);
    }
    .session-card input[type="radio"] { display: none; }
    .session-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 800; color: #fff; margin-bottom: 4px; }
    .session-sub { font-size: 12px; color: var(--text-muted); line-height: 1.4; }

    .guest-sync-wrapper {
        background: rgba(15, 12, 27, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: 16px 20px;
    }
    .guest-slider {
        width: 100%; -webkit-appearance: none; appearance: none;
        height: 6px; border-radius: 3px; background: rgba(255, 255, 255, 0.15);
        outline: none; margin: 14px 0 6px;
    }
    .guest-slider::-webkit-slider-thumb {
        -webkit-appearance: none; appearance: none;
        width: 20px; height: 20px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        cursor: pointer; box-shadow: 0 0 10px var(--primary-glow);
        border: 2px solid #fff;
    }

    .styles-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-bottom: 24px; }
    .style-card {
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(16, 13, 29, 0.7);
        border-radius: var(--radius-md);
        padding: 18px; cursor: pointer; transition: all 0.3s ease;
    }
    .style-card.selected {
        border-color: var(--primary);
        background: rgba(36, 24, 66, 0.85);
        box-shadow: 0 0 25px var(--primary-glow);
    }
    .style-card input[type="radio"] { display: none; }
    .style-title { font-size: 15px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
    .style-desc { font-size: 12px; color: var(--text-muted); line-height: 1.4; }

    .tiers-stack { display: flex; flex-direction: column; gap: 16px; margin-bottom: 20px; }
    .tier-card {
        border: 1px solid rgba(255, 255, 255, 0.12);
        background: rgba(18, 14, 34, 0.75);
        border-radius: var(--radius-md);
        padding: 20px; cursor: pointer; transition: all 0.3s ease;
    }
    .tier-card.selected {
        border-color: var(--gold);
        background: rgba(35, 25, 52, 0.95);
        box-shadow: 0 0 25px var(--gold-glow);
    }
    .tier-card input[type="radio"] { display: none; }
    .tier-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; }
    .tier-name { font-size: 17px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px; }
    .tier-price { font-size: 18px; font-weight: 800; color: var(--gold); text-align: right; }
    .tier-price span { font-size: 11px; font-weight: 400; color: var(--text-muted); display: block; }
    .tier-tagline { font-size: 12px; color: var(--text-muted); margin-bottom: 12px; }
    .tier-bullets { list-style: none; display: grid; grid-template-columns: 1fr 1fr; gap: 6px 12px; font-size: 11px; color: #cbd5e1; }
    .tier-bullets li { display: flex; align-items: center; gap: 6px; }
    .tier-bullets li i { color: #10b981; font-size: 10px; }

    .food-calc-link-box {
        background: rgba(245, 158, 11, 0.08);
        border: 1px dashed rgba(245, 158, 11, 0.35);
        border-radius: var(--radius-sm);
        padding: 12px 18px;
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
    }

    .service-group {
        background: rgba(14, 11, 24, 0.55);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-md);
        padding: 20px; margin-bottom: 20px;
    }
    .service-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
    .package-options { display: flex; flex-direction: column; gap: 10px; }
    .package-card {
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(22, 17, 39, 0.6);
        border-radius: var(--radius-sm);
        padding: 14px 16px; cursor: pointer;
        display: flex; align-items: center; justify-content: space-between; gap: 14px;
    }
    .package-card.selected {
        border-color: var(--primary);
        background: rgba(43, 29, 82, 0.8);
        box-shadow: 0 0 15px rgba(139, 92, 246, 0.3);
    }
    .package-card input[type="radio"] { margin-right: 8px; accent-color: var(--primary); }
    .package-info { flex: 1; }
    .package-title { font-size: 13px; font-weight: 700; color: #fff; }
    .package-vendor { font-size: 11px; color: #a78bfa; font-weight: 600; }
    .package-desc { font-size: 11px; color: var(--text-muted); margin-top: 3px; }
    .package-pricing { text-align: right; font-size: 14px; font-weight: 800; color: #38bdf8; white-space: nowrap; }
    .package-pricing span { font-size: 10px; font-weight: 400; color: var(--text-dim); display: block; }

    /* Venue Selection Cards */
    .venues-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-bottom: 16px; }
    @media (max-width: 640px) { .venues-grid { grid-template-columns: 1fr; } }
    .venue-card {
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(18, 14, 34, 0.7);
        border-radius: var(--radius-md);
        padding: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    .venue-card:hover {
        border-color: rgba(139, 92, 246, 0.5);
        background: rgba(28, 21, 52, 0.85);
        transform: translateY(-2px);
    }
    .venue-card.selected {
        border-color: var(--primary);
        background: rgba(43, 29, 82, 0.9);
        box-shadow: 0 0 22px var(--primary-glow);
    }

    .dossier-section-title {
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #e2e8f0;
        margin: 22px 0 12px;
        padding-bottom: 6px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dossier-section-title:first-of-type { margin-top: 0; }

    .review-dossier {
        background: rgba(14, 11, 25, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        padding: 24px; margin-bottom: 22px;
    }
    .dossier-grid {
        display: grid; grid-template-columns: repeat(2, 1fr);
        gap: 16px; margin-bottom: 16px;
    }
    .dossier-item small { display: block; font-size: 11px; text-transform: uppercase; color: var(--text-dim); font-weight: 700; margin-bottom: 3px; }
    .dossier-item span { font-size: 14px; font-weight: 700; color: #fff; }

    .calc-breakdown-table { width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 16px; }
    .calc-breakdown-table th { text-align: left; padding: 8px 0; font-size: 11px; color: var(--text-dim); text-transform: uppercase; border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
    .calc-breakdown-table td { padding: 10px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04); color: #e2e8f0; }
    .calc-breakdown-table .amount-col { text-align: right; font-weight: 700; color: #fff; }
    .total-row td { border-top: 1px solid rgba(255, 255, 255, 0.2); border-bottom: none; padding-top: 14px; font-size: 16px; font-weight: 800; }
    .total-row .amount-col { color: var(--gold); font-size: 20px; }

    .wizard-nav { display: flex; align-items: center; justify-content: space-between; margin-top: 28px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.08); }
    .btn-glass {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 24px; border-radius: 30px; font-size: 14px;
        font-weight: 700; cursor: pointer; transition: all 0.3s ease; border: none; text-decoration: none;
    }
    .btn-prev { background: rgba(255, 255, 255, 0.06); color: #cbd5e1; border: 1px solid rgba(255, 255, 255, 0.12); }
    .btn-prev:hover { background: rgba(255, 255, 255, 0.14); color: #fff; }
    .btn-next { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; box-shadow: 0 4px 20px var(--primary-glow); }
    .btn-next:hover { transform: translateY(-2px); box-shadow: 0 6px 25px var(--primary-glow); }
    .btn-confirm { background: linear-gradient(135deg, #10b981, #059669); color: #fff; padding: 14px 32px; font-size: 15px; box-shadow: 0 4px 20px rgba(16, 185, 129, 0.4); }
    .btn-confirm:hover { transform: translateY(-2px); box-shadow: 0 6px 28px rgba(16, 185, 129, 0.5); }

    .sidebar-telemetry { position: sticky; top: 100px; display: flex; flex-direction: column; gap: 24px; }
    .telemetry-card {
        background: var(--surface-glass); border: 1px solid var(--surface-glass-border);
        border-radius: var(--radius-lg); padding: 26px; box-shadow: var(--shadow-glass);
        backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    }
    .telemetry-title { font-size: 13px; font-weight: 800; text-transform: uppercase; color: var(--text-dim); margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; }
    .live-pulse { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; color: #10b981; font-weight: 700; }
    .pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: #10b981; box-shadow: 0 0 10px #10b981; animation: pulseAnim 1.8s infinite; }
    @keyframes pulseAnim { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.4; transform: scale(0.8); } }

    .live-total-display {
        background: rgba(14, 11, 26, 0.8); border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-md); padding: 18px; text-align: center; margin-bottom: 18px;
    }
    .live-total-display small { font-size: 12px; color: var(--text-muted); display: block; margin-bottom: 4px; }
    .live-total-amount { font-size: 28px; font-weight: 800; background: linear-gradient(135deg, #fbbf24, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

    .telemetry-breakdown-list { list-style: none; display: flex; flex-direction: column; gap: 10px; font-size: 12px; color: var(--text-muted); margin-bottom: 18px; }
    .telemetry-breakdown-list li { display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid rgba(255, 255, 255, 0.04); }
    .telemetry-breakdown-list li span:last-child { font-weight: 700; color: #fff; }

    .guarantee-badge {
        display: flex; align-items: center; gap: 10px; padding: 12px;
        border-radius: var(--radius-sm); background: rgba(16, 185, 129, 0.08);
        border: 1px solid rgba(16, 185, 129, 0.2); font-size: 11px; color: #6ee7b7;
    }
</style>

<div class="wizard-wrapper">
    <!-- Ambient Glowing Orbs -->
    <div class="ambient-orb orb-1"></div>
    <div class="ambient-orb orb-2"></div>
    <div class="ambient-orb orb-3"></div>

    <div class="wizard-container">

        <!-- Wizard Headline -->
        <div class="wizard-header">
            <div class="curated-badge">
                <i class="fas fa-gem"></i> Planning a Royal Wedding?
            </div>
            <h1 class="wizard-title">
                Book Your Celebration
            </h1>
            <p class="wizard-subtitle">
                Craft your royal celebration with our 4-stage bespoke concierge. Configure ceremony fundamentals, curate gourmet dining, pair with accredited artisans, and execute with atomic transaction assurance.
            </p>
        </div>

        <!-- 4-STAGE DYNAMIC STEPPER -->
        <div class="progress-stepper">
            <div class="stepper-track">
                <div class="stepper-progress-fill" id="stepperFill" style="width: 0%;"></div>
                
                <div class="step-node active" id="stepNode1" onclick="navigateToStage(1)">
                    <div class="node-bubble"><i class="fas fa-heart"></i></div>
                    <div class="node-label">1. Fundamentals</div>
                    <div class="node-subtext">Couple, Date & Session</div>
                </div>

                <div class="step-node" id="stepNode2" onclick="navigateToStage(2)">
                    <div class="node-bubble"><i class="fas fa-hotel"></i></div>
                    <div class="node-label">2. Venue & Catering</div>
                    <div class="node-subtext">Hall, Style & Banquet</div>
                </div>

                <div class="step-node" id="stepNode3" onclick="navigateToStage(3)">
                    <div class="node-bubble"><i class="fas fa-camera-retro"></i></div>
                    <div class="node-label">3. Artisans & Add-ons</div>
                    <div class="node-subtext">Vetted Specialists</div>
                </div>

                <div class="step-node" id="stepNode4" onclick="navigateToStage(4)">
                    <div class="node-bubble"><i class="fas fa-receipt"></i></div>
                    <div class="node-label">4. Review & Confirm</div>
                    <div class="node-subtext">Live Total & Lock</div>
                </div>
            </div>
        </div>

        <!-- WIZARD INTERFACE -->
        <div class="wizard-layout">
            
            <!-- LEFT: STAGE FORM PANE -->
            <form id="weddingWizardForm" method="POST" action="{{ route('booking.store') }}">
                @csrf
                <input type="hidden" name="action" value="confirm_wedding_booking">
                <input type="hidden" name="EventType" value="Weddings">

                <div class="glass-panel">

                    <!-- =======================================================
                         STAGE 1: FUNDAMENTALS (Couple, Venue, Date, Guests)
                    ======================================================= -->
                    <div class="stage-pane active" id="stage1">
                        <div class="stage-legend">
                            <div class="stage-icon"><i class="fas fa-heart"></i></div>
                            <div>
                                <div class="stage-title">Ceremony Fundamentals</div>
                                <div class="stage-desc">Establish the core date, venue setting, and expected guest attendance.</div>
                            </div>
                        </div>

                        <!-- Client Identity Badge -->
                        <div style="background: rgba(15, 12, 27, 0.6); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <small style="color: var(--text-dim); font-size: 11px; font-weight: 700; text-transform: uppercase;">Logged In Client</small>
                                <div style="font-weight: 800; font-size: 14px; color: #fff;">
                                    {{ Auth::user()->fullname ?? Auth::user()->username }} ({{ Auth::user()->email }})
                                </div>
                            </div>
                            <span style="background: rgba(16, 185, 129, 0.15); color: #6ee7b7; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">
                                <i class="fas fa-shield-alt"></i> Verified Buyer Account
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="couple_names">
                                Couple's Full Names (Partner 1 & Partner 2) <span class="req">*</span>
                            </label>
                            <input type="text" id="couple_names" name="couple_names" class="input-glass" 
                                   placeholder="e.g. Kasun Fernando & Dinithi Perera" 
                                   value="{{ old('couple_names', Auth::user()->fullname ?? '') }}" required>
                        </div>

                        <div class="form-row form-group">
                            <div>
                                <label class="input-label" for="contact_phone">
                                    Primary Contact Phone <span class="req">*</span>
                                </label>
                                <input type="tel" id="contact_phone" name="contact_phone" class="input-glass" 
                                       placeholder="e.g. +94 77 123 4567" 
                                       value="{{ old('contact_phone', Auth::user()->phone ?? '+94 77 123 4567') }}" required>
                            </div>
                            <div>
                                <label class="input-label" for="contact_email">
                                    Direct Contact Email <span class="req">*</span>
                                </label>
                                <input type="email" id="contact_email" name="contact_email" class="input-glass" 
                                       placeholder="e.g. couple@eventflare.com" 
                                       value="{{ old('contact_email', Auth::user()->email ?? '') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="event_date">
                                Wedding Auspicious Date <span class="req">*</span>
                            </label>
                            <input type="date" id="event_date" name="EventDate" class="input-glass" 
                                   min="{{ date('Y-m-d') }}" 
                                   value="{{ old('EventDate', date('Y-m-d', strtotime('+30 days'))) }}" required 
                                   onchange="syncDossierReview()">
                        </div>

                        <!-- Session Timing -->
                        <div class="form-group">
                            <label class="input-label">Session Timing <span class="req">*</span></label>
                            <div class="session-selector">
                                <label class="session-card {{ old('DayNight', 'Night') === 'Day' ? 'selected' : '' }}" id="cardDay">
                                    <input type="radio" name="DayNight" value="Day" {{ old('DayNight', 'Night') === 'Day' ? 'checked' : '' }} onchange="updateSessionCard()">
                                    <div class="session-badge"><i class="fas fa-sun" style="color: #f59e0b;"></i> Daytime Auspicious</div>
                                    <div class="session-sub">Morning Poruwa rituals & celebratory afternoon luncheon (09:00 - 15:30).</div>
                                </label>
                                <label class="session-card {{ old('DayNight', 'Night') === 'Night' ? 'selected' : '' }}" id="cardNight">
                                    <input type="radio" name="DayNight" value="Night" {{ old('DayNight', 'Night') === 'Night' ? 'checked' : '' }} onchange="updateSessionCard()">
                                    <div class="session-badge"><i class="fas fa-moon" style="color: #818cf8;"></i> Starlight Evening Gala</div>
                                    <div class="session-sub">Sunset ceremonies, ambient ballroom lighting & evening banquet (17:30 - 23:45).</div>
                                </label>
                            </div>
                        </div>

                        <!-- Guest Count Slider + Synchronized Input -->
                        <div class="form-group">
                            <label class="input-label" for="number_of_guests">
                                Expected Guest Capacity (20 to 1,500 Attendees) <span class="req">*</span>
                            </label>
                            <div class="guest-sync-wrapper">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 13px; color: var(--text-muted); font-weight: 600;">Guest Headcount:</span>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <input type="number" id="number_of_guests" name="NumberOfGuests" class="input-glass" 
                                               style="width: 110px; text-align: center; font-weight: 800; font-size: 16px; padding: 6px 10px;" 
                                               min="20" max="1500" value="{{ old('NumberOfGuests', $preGuests > 0 ? $preGuests : 150) }}" required oninput="syncGuestSlider(this.value)">
                                        <span style="font-size: 13px; color: var(--text-dim);">Guests</span>
                                    </div>
                                </div>
                                <input type="range" id="guest_slider" class="guest-slider" min="20" max="1500" step="5" 
                                       value="{{ old('NumberOfGuests', $preGuests > 0 ? $preGuests : 150) }}" oninput="syncGuestNumber(this.value)">
                                <div style="display: flex; justify-content: space-between; font-size: 11px; color: var(--text-dim); margin-top: 4px;">
                                    <span>20 Intimate</span>
                                    <span>350 Typical</span>
                                    <span>750 Grand</span>
                                    <span>1500 Imperial</span>
                                </div>
                            </div>
                        </div>

                        <div class="wizard-nav" style="justify-content: flex-end;">
                            <button type="button" class="btn-glass btn-next" onclick="validateAndGoStage(2)">
                                Next: Venue & Catering <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- =======================================================
                         STAGE 2: VENUE, STYLE & CATERING (Hall, Style, Tiers)
                    ======================================================= -->
                    <div class="stage-pane" id="stage2">
                        <div class="stage-legend">
                            <div class="stage-icon"><i class="fas fa-hotel"></i></div>
                            <div>
                                <div class="stage-title">Hall, Style & Catering Tiers</div>
                                <div class="stage-desc">Select your certified banquet hall, cultural ceremonial style, and curated gourmet tier.</div>
                            </div>
                        </div>

                        <!-- 1. Hall / Destination Venue -->
                        <div class="form-group">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <label class="input-label" style="margin-bottom: 0;">
                                    Hall / Destination Venue <span class="req">*</span>
                                </label>
                                <span style="font-size: 11px; color: #a78bfa; font-weight: 600;">
                                    <i class="fas fa-certificate"></i> Certified Partner Venues
                                </span>
                            </div>

                            @php
                                $currentVenue = old('Place', $preVenue ?: 'Shangri-La Colombo');
                                $venuesList = [
                                    [
                                        'id' => 'venue_shangrila',
                                        'name' => 'Shangri-La Colombo',
                                        'tag' => '5-Star Grand Ballroom',
                                        'location' => 'Galle Face Green, Colombo 02',
                                        'capacity' => 'Up to 1,500 Guests',
                                        'icon' => 'fas fa-hotel',
                                        'color' => '#8b5cf6'
                                    ],
                                    [
                                        'id' => 'venue_cinnamon',
                                        'name' => 'Cinnamon Grand Colombo',
                                        'tag' => 'Oak Room & Atrium',
                                        'location' => 'Kollupitiya, Colombo 03',
                                        'capacity' => 'Up to 800 Guests',
                                        'icon' => 'fas fa-landmark',
                                        'color' => '#ec4899'
                                    ],
                                    [
                                        'id' => 'venue_kingsbury',
                                        'name' => 'Kingsbury Victorian Ballroom',
                                        'tag' => 'Colonial Opulence',
                                        'location' => 'Janthana Mawatha, Colombo Fort',
                                        'capacity' => 'Up to 500 Guests',
                                        'icon' => 'fas fa-crown',
                                        'color' => '#f59e0b'
                                    ],
                                    [
                                        'id' => 'venue_jetwing',
                                        'name' => 'Jetwing Blue Negombo',
                                        'tag' => 'Coastal Beachfront Ballroom',
                                        'location' => 'Porutota Road, Negombo',
                                        'capacity' => 'Up to 600 Guests',
                                        'icon' => 'fas fa-umbrella-beach',
                                        'color' => '#3b82f6'
                                    ],
                                    [
                                        'id' => 'venue_earls',
                                        'name' => "Earl's Regency Kandy",
                                        'tag' => 'Regal Mountain Pavilion',
                                        'location' => 'Tennekumbura, Kandy',
                                        'capacity' => 'Up to 450 Guests',
                                        'icon' => 'fas fa-mountain',
                                        'color' => '#10b981'
                                    ],
                                    [
                                        'id' => 'venue_custom',
                                        'name' => 'Bespoke / Destination Venue',
                                        'tag' => 'Custom Private Estate / Resort',
                                        'location' => 'Specify Your Location Below',
                                        'capacity' => 'Custom Attendance',
                                        'icon' => 'fas fa-map-marker-alt',
                                        'color' => '#c084fc'
                                    ],
                                ];
                            @endphp

                            <div class="venues-grid">
                                @foreach($venuesList as $v)
                                    @php
                                        $isMatch = ($v['name'] === $currentVenue) || ($v['id'] === 'venue_kingsbury' && stripos($currentVenue, 'Kingsbury') !== false);
                                    @endphp
                                    <div class="venue-card {{ $isMatch ? 'selected' : '' }}" 
                                         id="{{ $v['id'] }}" 
                                         onclick="selectVenueCard('{{ addslashes($v['name']) }}', '{{ $v['id'] }}')">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                            <div style="font-size: 15px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px;">
                                                <i class="{{ $v['icon'] }}" style="color: {{ $v['color'] }};"></i> {{ $v['name'] }}
                                            </div>
                                            <span style="background: rgba(255,255,255,0.08); font-size: 10px; font-weight: 700; color: #cbd5e1; padding: 2px 8px; border-radius: 10px;">
                                                {{ $v['tag'] }}
                                            </span>
                                        </div>
                                        <div style="font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                                            <i class="fas fa-map-pin" style="font-size: 11px; color: var(--text-dim);"></i> {{ $v['location'] }}
                                        </div>
                                        <div style="font-size: 11px; color: #a78bfa; font-weight: 600;">
                                            <i class="fas fa-users" style="font-size: 10px;"></i> {{ $v['capacity'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Confirmed Venue Text Input -->
                            <div>
                                <label class="input-label" for="place" style="font-size: 12px; color: var(--text-muted); margin-bottom: 6px;">
                                    Confirmed Banquet Hall / Custom Venue Location:
                                </label>
                                <input type="text" id="place" name="Place" class="input-glass" 
                                       placeholder="Click a venue card above or enter custom banquet hall / estate name..." 
                                       value="{{ old('Place', $preVenue ?: 'Shangri-La Colombo') }}" required 
                                       oninput="onCustomVenueInput(this.value)">
                            </div>
                        </div>

                        <!-- 2. Aesthetic & Cultural Nuptial Style -->
                        @php
                            $activeStyle = 'Traditional';
                            if (stripos($preStyle, 'west') !== false || stripos($preStyle, 'church') !== false) {
                                $activeStyle = 'Western';
                            } elseif (stripos($preStyle, 'beach') !== false || stripos($preStyle, 'coast') !== false) {
                                $activeStyle = 'Beach';
                            } elseif (stripos($preStyle, 'ball') !== false || stripos($preStyle, 'hotel') !== false) {
                                $activeStyle = 'Ballroom';
                            }
                        @endphp

                        <div class="form-group" style="margin-top: 26px;">
                            <label class="input-label">Aesthetic & Cultural Nuptial Style <span class="req">*</span></label>
                            <div class="styles-grid">
                                @foreach($culturalStyles as $styleKey => $st)
                                    <label class="style-card {{ $styleKey === $activeStyle ? 'selected' : '' }}" id="styleCard_{{ $styleKey }}">
                                        <input type="radio" name="cultural_style" value="{{ $styleKey }}" {{ $styleKey === $activeStyle ? 'checked' : '' }} onchange="updateStyleCard()">
                                        <div class="style-title">
                                            <i class="{{ $st['icon'] }}" style="color: {{ $st['color'] }};"></i> {{ $st['title'] }}
                                        </div>
                                        <div class="style-desc">{{ $st['desc'] }}</div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- 3. Curated Catering Tier (Per Head Rate) -->
                        <div class="form-group" style="margin-top: 26px;">
                            <label class="input-label">Curated Catering Tier (Per Head Rate) <span class="req">*</span></label>
                            <div class="tiers-stack">
                                @foreach($cateringTiers as $key => $tier)
                                    <label class="tier-card {{ $key === 'Executive' ? 'selected' : '' }}" id="tierCard_{{ $key }}">
                                        <input type="radio" name="catering_tier" value="{{ $key }}" 
                                               data-rate="{{ $tier['rate'] }}" 
                                               {{ $key === 'Executive' ? 'checked' : '' }} 
                                               onchange="updateTierCard(); recalculateTotals();">
                                        <div class="tier-top">
                                            <div>
                                                <div class="tier-name">
                                                    <i class="fas fa-crown" style="color: var(--gold);"></i> {{ $tier['name'] }}
                                                    <span style="background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.3); color: var(--gold); font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 10px; margin-left: 6px;">
                                                        {{ $tier['badge'] }}
                                                    </span>
                                                </div>
                                                <div class="tier-tagline">{{ $tier['tagline'] }}</div>
                                            </div>
                                            <div class="tier-price">
                                                LKR {{ number_format($tier['rate']) }}
                                                <span>per guest</span>
                                            </div>
                                        </div>
                                        <ul class="tier-bullets">
                                            @foreach($tier['highlights'] as $item)
                                                <li><i class="fas fa-check-circle"></i> {{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Deep Link to Custom Food Calculator -->
                            <div class="food-calc-link-box">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-calculator" style="color: var(--gold); font-size: 18px;"></i>
                                    <span style="font-size: 12px; color: #fde68a;">
                                        Need a specialized custom menu with vegan or halal partitions?
                                    </span>
                                </div>
                                <a href="{{ route('food-calculator') }}" target="_blank" class="nav-back-link" style="color: var(--gold); border-color: rgba(245,158,11,0.3); font-size: 12px; text-decoration: none;">
                                    Open Food Calculator <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>

                        <div class="wizard-nav">
                            <button type="button" class="btn-glass btn-prev" onclick="navigateToStage(1)">
                                <i class="fas fa-arrow-left"></i> Back to Fundamentals
                            </button>
                            <button type="button" class="btn-glass btn-next" onclick="validateAndGoStage(3)">
                                Next: Certified Artisans <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- =======================================================
                         STAGE 3: CERTIFIED ARTISANS & PACKAGES
                    ======================================================= -->
                    <div class="stage-pane" id="stage3">
                        <div class="stage-legend">
                            <div class="stage-icon"><i class="fas fa-camera"></i></div>
                            <div>
                                <div class="stage-title">Accredited Wedding Artisans</div>
                                <div class="stage-desc">Handpick vetted florists, traditional troupes, and cinematic photographers for your date.</div>
                            </div>
                        </div>

                        @if($services->isNotEmpty())
                            @foreach($services as $srv)
                                <div class="service-group">
                                    <div class="service-header">
                                        <h4>
                                            <i class="fas fa-sparkles" style="color: #a78bfa;"></i>
                                            {{ $srv->service_name }}
                                            @if($srv->is_required)
                                                <span style="background: rgba(239,68,68,0.15); color: #fca5a5; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 6px; margin-left: 6px;">Essential</span>
                                            @endif
                                        </h4>
                                    </div>

                                    <div class="package-options">
                                        @if(!$srv->is_required)
                                            <label class="package-card selected" id="pkg_none_{{ $srv->service_id }}">
                                                <div style="display: flex; align-items: center;">
                                                    <input type="radio" name="selected_packages[{{ $srv->service_id }}]" value="" 
                                                           data-cost="0" data-type="flat" checked 
                                                           onchange="updatePackageSelection(this); recalculateTotals();">
                                                    <div class="package-info">
                                                        <div class="package-title" style="color: var(--text-muted);">
                                                            <i class="fas fa-minus-circle"></i> Omit this optional service
                                                        </div>
                                                        <div class="package-desc">No specialized third-party artisan assigned for this ritual.</div>
                                                    </div>
                                                </div>
                                                <div class="package-pricing" style="color: var(--text-dim);">LKR 0</div>
                                            </label>
                                        @endif

                                        @if($srv->listings->isNotEmpty())
                                            @foreach($srv->listings as $idx => $pkg)
                                                @php 
                                                    $isPerPerson = ($pkg->price_type === 'per_person');
                                                    $autoSelect = ($srv->is_required && $idx === 0);
                                                @endphp
                                                <label class="package-card {{ $autoSelect ? 'selected' : '' }}" id="pkg_{{ $pkg->listing_id }}">
                                                    <div style="display: flex; align-items: center;">
                                                        <input type="radio" name="selected_packages[{{ $srv->service_id }}]" 
                                                               value="{{ $pkg->listing_id }}" 
                                                               data-name="{{ $pkg->title }}"
                                                               data-vendor="{{ $pkg->supplier->business_name ?? 'Accredited Supplier' }}"
                                                               data-unit-price="{{ $pkg->price }}" 
                                                               data-type="{{ $pkg->price_type }}" 
                                                               {{ $autoSelect ? 'checked' : '' }} 
                                                               onchange="updatePackageSelection(this); recalculateTotals();">
                                                        <div class="package-info">
                                                            <div class="package-title">{{ $pkg->title }}</div>
                                                            <div class="package-vendor"><i class="fas fa-certificate"></i> {{ $pkg->supplier->business_name ?? 'Certified Vendor' }}</div>
                                                            <div class="package-desc">{{ $pkg->description }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="package-pricing">
                                                        LKR {{ number_format($pkg->price) }}
                                                        <span>{{ $isPerPerson ? 'per attendee' : 'flat package' }}</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="service-group">
                                <div class="service-header">
                                    <h4><i class="fas fa-sparkles" style="color: #a78bfa;"></i> Poruwa & Floral Mandap Decor</h4>
                                </div>
                                <div class="package-options">
                                    <label class="package-card selected">
                                        <div style="display: flex; align-items: center;">
                                            <input type="radio" name="selected_packages[1]" value="101" data-name="Imperial Gold Lotus Poruwa" data-vendor="Royal Flora Design Studio" data-unit-price="175000" data-type="total_package" checked onchange="updatePackageSelection(this); recalculateTotals();">
                                            <div class="package-info">
                                                <div class="package-title">Imperial Gold Lotus Poruwa</div>
                                                <div class="package-vendor"><i class="fas fa-certificate"></i> Royal Flora Design Studio</div>
                                                <div class="package-desc">Triple-tiered carved wood mandap with fresh jasmine trails and traditional brass oil lamps.</div>
                                            </div>
                                        </div>
                                        <div class="package-pricing">LKR 175,000<span>flat package</span></div>
                                    </label>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="input-label" for="equipment">
                                Stage, Audio & Atmospheric Lighting Customizations (Optional)
                            </label>
                            <input type="text" id="equipment" name="equipment" class="input-glass" 
                                   placeholder="e.g. Dry ice fog for first dance, 4 wireless lapel mics, customized gold initials gobo" 
                                   value="{{ old('equipment') }}" oninput="syncDossierReview()">
                        </div>

                        <div class="wizard-nav">
                            <button type="button" class="btn-glass btn-prev" onclick="navigateToStage(2)">
                                <i class="fas fa-arrow-left"></i> Back to Style & Catering
                            </button>
                            <button type="button" class="btn-glass btn-next" onclick="navigateToStage(4)">
                                Review & Confirm Dossier <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- =======================================================
                         STAGE 4: REVIEW & ATOMIC CONFIRMATION
                    ======================================================= -->
                    <div class="stage-pane" id="stage4">
                        <div class="stage-legend">
                            <div class="stage-icon"><i class="fas fa-clipboard-check"></i></div>
                            <div>
                                <div class="stage-title">Dossier Review & Final Lock</div>
                                <div class="stage-desc">Verify your comprehensive celebration blueprint, review live line-item finances, and execute atomic reservation.</div>
                            </div>
                        </div>

                        <div class="review-dossier">
                            <!-- 1. Celebrants & Primary Contact -->
                            <div class="dossier-section-title">
                                <i class="fas fa-user-friends" style="color: #ec4899;"></i> 1. Celebrants & Contact Dossier
                            </div>
                            <div class="dossier-grid">
                                <div class="dossier-item">
                                    <small>Honored Couple Names</small>
                                    <span id="revCoupleNames">Kasun Fernando & Dinithi Perera</span>
                                </div>
                                <div class="dossier-item">
                                    <small>Primary Contact Phone</small>
                                    <span id="revContactPhone">+94 77 123 4567</span>
                                </div>
                                <div class="dossier-item">
                                    <small>Direct Contact Email</small>
                                    <span id="revContactEmail">couple@eventflare.com</span>
                                </div>
                                <div class="dossier-item">
                                    <small>Client Account</small>
                                    <span id="revClientAccount">{{ Auth::user()->fullname ?? Auth::user()->username }} (Verified Buyer)</span>
                                </div>
                            </div>

                            <!-- 2. Logistics, Date & Venue Setting -->
                            <div class="dossier-section-title">
                                <i class="fas fa-calendar-alt" style="color: #f59e0b;"></i> 2. Ceremony Logistics & Venue Setting
                            </div>
                            <div class="dossier-grid">
                                <div class="dossier-item">
                                    <small>Wedding Auspicious Date</small>
                                    <span id="revEventDate">Pending Date</span>
                                </div>
                                <div class="dossier-item">
                                    <small>Session Timing</small>
                                    <span id="revSessionTiming">Starlight Evening Gala (17:30 - 23:45)</span>
                                </div>
                                <div class="dossier-item" style="grid-column: span 2;">
                                    <small>Banquet Hall / Destination Venue</small>
                                    <span id="revVenue" style="color: #c4b5fd; font-weight: 800;">Shangri-La Colombo</span>
                                </div>
                                <div class="dossier-item">
                                    <small>Guest Attendance</small>
                                    <span id="revHeadcount">150 Guests</span>
                                </div>
                                <div class="dossier-item">
                                    <small>Aesthetic & Cultural Nuptial Style</small>
                                    <span id="revStyle">Traditional Poruwa</span>
                                </div>
                            </div>

                            <!-- 3. Catering & Dining Specifications -->
                            <div class="dossier-section-title">
                                <i class="fas fa-utensils" style="color: #10b981;"></i> 3. Gourmet Dining & Catering Tier
                            </div>
                            <div class="dossier-grid">
                                <div class="dossier-item">
                                    <small>Selected Catering Tier</small>
                                    <span id="revCateringTier" style="color: var(--gold); font-weight: 800;">Executive Royal Tier</span>
                                </div>
                                <div class="dossier-item">
                                    <small>Per-Head Rate</small>
                                    <span id="revCateringRate">LKR 4,800 per guest</span>
                                </div>
                                <div class="dossier-item" style="grid-column: span 2;">
                                    <small>Catering Base Investment</small>
                                    <span id="revCateringSubtotal" style="color: #38bdf8; font-weight: 800;">LKR 720,000.00</span>
                                </div>
                            </div>

                            <!-- 4. Accredited Artisans & Stage Production -->
                            <div class="dossier-section-title">
                                <i class="fas fa-gem" style="color: #a78bfa;"></i> 4. Accredited Artisans & Production
                            </div>
                            <div style="margin-bottom: 14px;">
                                <ul id="revArtisansList" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                                    <!-- Populated dynamically -->
                                </ul>
                            </div>
                            <div class="dossier-grid">
                                <div class="dossier-item" style="grid-column: span 2;">
                                    <small>Stage, Audio & Lighting Customizations</small>
                                    <span id="revEquipment" style="color: #e2e8f0; font-weight: 500;">None specified (Standard Ballroom AV)</span>
                                </div>
                            </div>

                            <!-- 5. Timeline Coordination & Dietary Notes -->
                            <div class="dossier-section-title">
                                <i class="fas fa-clipboard-list" style="color: #60a5fa;"></i> 5. Timeline Coordination & Special Notes
                            </div>
                            <div class="dossier-grid">
                                <div class="dossier-item" style="grid-column: span 2;">
                                    <small>Dietary Requirements & Timeline Specifications</small>
                                    <span id="revExtraNotes" style="color: #e2e8f0; font-weight: 500; white-space: pre-line;">Standard itinerary without special dietary partitions.</span>
                                </div>
                            </div>

                            <!-- 6. Consolidated Financial Ledger -->
                            <div class="dossier-section-title">
                                <i class="fas fa-receipt" style="color: var(--gold);"></i> 6. Itemized Financial Investment Ledger
                            </div>
                            <table class="calc-breakdown-table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th style="text-align: center;">Rate Type</th>
                                        <th class="amount-col">Subtotal (LKR)</th>
                                    </tr>
                                </thead>
                                <tbody id="reviewTableBody"></tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="2">Consolidated Reservation Total</td>
                                        <td class="amount-col" id="reviewGrandTotal">LKR 0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="ExtraDetails">
                                Additional Itinerary Instructions & Special Notes (Optional)
                            </label>
                            <textarea id="ExtraDetails" name="ExtraDetails" class="input-glass" rows="3" 
                                      placeholder="Any specific nekath times, vegetarian/halal plate quotas, VIP guest requests, or timeline coordination notes..." 
                                      oninput="syncDossierReview()">{{ old('ExtraDetails', $preDetails) }}</textarea>
                        </div>

                        <div class="guarantee-badge" style="margin-bottom: 24px;">
                            <i class="fas fa-shield-check" style="font-size: 18px;"></i>
                            <span><strong>MySQL Atomic Transaction Protected:</strong> Clicking "Confirm & Lock Wedding Date" reserves your date and commits all supplier records atomically.</span>
                        </div>

                        <div class="wizard-nav">
                            <button type="button" class="btn-glass btn-prev" onclick="navigateToStage(3)">
                                <i class="fas fa-arrow-left"></i> Back to Artisans
                            </button>
                            <button type="submit" class="btn-glass btn-confirm">
                                <i class="fas fa-gem"></i> Confirm & Lock Wedding Date
                            </button>
                        </div>
                    </div>

                </div>
            </form>

            <!-- RIGHT: LIVE TELEMETRY CARD -->
            <aside class="sidebar-telemetry">
                <div class="telemetry-card">
                    <div class="telemetry-title">
                        <span>Live Nuptial Telemetry</span>
                        <div class="live-pulse"><div class="pulse-dot"></div> Live Sync</div>
                    </div>
                    <div class="live-total-display">
                        <small>Estimated Nuptial Investment</small>
                        <div class="live-total-amount" id="telemetryGrandTotal">LKR 0</div>
                    </div>
                    <ul class="telemetry-breakdown-list">
                        <li><span>Guest Headcount</span><span id="telemetryGuests">150 Guests</span></li>
                        <li><span>Catering Base (<span id="telemetryTierName">Executive</span>)</span><span id="telemetryCateringTotal">LKR 0</span></li>
                        <li><span>Artisans & Packages Total</span><span id="telemetryPackagesTotal">LKR 0</span></li>
                        <li><span>Ceremonial Style</span><span id="telemetryStyle">Traditional</span></li>
                    </ul>
                    <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 14px; font-size: 11px; color: var(--text-dim); line-height: 1.5;">
                        <i class="fas fa-info-circle" style="color: #a78bfa;"></i> 
                        All prices in Sri Lankan Rupees (LKR). Certified suppliers are automatically locked upon reservation confirmation.
                    </div>
                </div>

                <div class="telemetry-card" style="padding: 22px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #fff; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-award" style="color: var(--gold);"></i> EVENTFLARE Nuptial Guarantee
                    </h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 10px; font-size: 12px; color: var(--text-muted);">
                        <li style="display: flex; gap: 8px;"><i class="fas fa-check" style="color: #10b981; margin-top: 2px;"></i><span><strong>Vetted Suppliers:</strong> Direct liability agreements with certified banquet halls.</span></li>
                        <li style="display: flex; gap: 8px;"><i class="fas fa-check" style="color: #10b981; margin-top: 2px;"></i><span><strong>Real-time Telemetry:</strong> Transparent itemized calculations with zero hidden fees.</span></li>
                        <li style="display: flex; gap: 8px;"><i class="fas fa-check" style="color: #10b981; margin-top: 2px;"></i><span><strong>Instant Dossier:</strong> Immediate printable PDF itinerary slip in MyBookings.</span></li>
                    </ul>
                </div>
            </aside>

        </div>

    </div>
</div>

<script>
    let currentStage = 1;

    function formatLKR(amount) {
        return 'LKR ' + Number(amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function syncGuestSlider(val) {
        const num = Math.max(20, Math.min(1500, parseInt(val) || 20));
        document.getElementById('guest_slider').value = num;
        recalculateTotals();
    }

    function syncGuestNumber(val) {
        document.getElementById('number_of_guests').value = val;
        recalculateTotals();
    }

    function updateSessionCard() {
        const selected = document.querySelector('input[name="DayNight"]:checked').value;
        document.getElementById('cardDay').classList.toggle('selected', selected === 'Day');
        document.getElementById('cardNight').classList.toggle('selected', selected === 'Night');
    }

    function updateStyleCard() {
        const selected = document.querySelector('input[name="cultural_style"]:checked').value;
        ['Traditional', 'Western', 'Beach', 'Ballroom'].forEach(st => {
            const el = document.getElementById('styleCard_' + st);
            if (el) el.classList.toggle('selected', st === selected);
        });
        const telemetryStyle = document.getElementById('telemetryStyle');
        if (telemetryStyle) telemetryStyle.textContent = selected;
    }

    function updateTierCard() {
        const selected = document.querySelector('input[name="catering_tier"]:checked').value;
        ['Platinum', 'Executive', 'Cocktail'].forEach(t => {
            const el = document.getElementById('tierCard_' + t);
            if (el) el.classList.toggle('selected', t === selected);
        });
        const telemetryTier = document.getElementById('telemetryTierName');
        if (telemetryTier) telemetryTier.textContent = selected;
    }

    function updatePackageSelection(inputElem) {
        const groupName = inputElem.name;
        const allRadios = document.querySelectorAll(`input[name="${groupName}"]`);
        allRadios.forEach(radio => {
            const card = radio.closest('.package-card');
            if (card) card.classList.toggle('selected', radio.checked);
        });
    }

    function recalculateTotals() {
        const guestsInput = document.getElementById('number_of_guests');
        if (!guestsInput) return;

        const guests = Math.max(20, parseInt(guestsInput.value) || 20);

        const selectedTierRadio = document.querySelector('input[name="catering_tier"]:checked');
        const tierRate = selectedTierRadio ? parseFloat(selectedTierRadio.getAttribute('data-rate') || 4800) : 4800;
        const tierName = selectedTierRadio ? selectedTierRadio.value : 'Executive';
        const cateringTotal = guests * tierRate;

        let packagesTotal = 0;
        const lineItems = [];

        lineItems.push({
            name: `${tierName} Catering Tier (${guests} Guests @ LKR ${tierRate.toLocaleString()})`,
            type: 'Per Person',
            cost: cateringTotal
        });

        const packageRadios = document.querySelectorAll('input[name^="selected_packages"]:checked');
        packageRadios.forEach(radio => {
            const unitPrice = parseFloat(radio.getAttribute('data-unit-price') || 0);
            const priceType = radio.getAttribute('data-type') || 'total_package';
            const pkgName   = radio.getAttribute('data-name') || '';
            const vendor    = radio.getAttribute('data-vendor') || '';

            if (radio.value && unitPrice > 0) {
                let cost = unitPrice;
                let typeLabel = 'Flat Fee';
                if (priceType === 'per_person') {
                    cost = unitPrice * guests;
                    typeLabel = `Per Head (${guests} × ${unitPrice.toLocaleString()})`;
                }

                packagesTotal += cost;
                lineItems.push({
                    name: `${pkgName} — ${vendor}`,
                    type: typeLabel,
                    cost: cost
                });
            }
        });

        const grandTotal = cateringTotal + packagesTotal;

        const telGrand    = document.getElementById('telemetryGrandTotal');
        const telGuests   = document.getElementById('telemetryGuests');
        const telCatering = document.getElementById('telemetryCateringTotal');
        const telPackages = document.getElementById('telemetryPackagesTotal');

        if (telGrand)    telGrand.textContent = formatLKR(grandTotal);
        if (telGuests)   telGuests.textContent = `${guests} Guests`;
        if (telCatering) telCatering.textContent = formatLKR(cateringTotal);
        if (telPackages) telPackages.textContent = formatLKR(packagesTotal);

        const reviewTableBody = document.getElementById('reviewTableBody');
        const reviewGrandTotal = document.getElementById('reviewGrandTotal');

        if (reviewTableBody) {
            reviewTableBody.innerHTML = '';
            lineItems.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td style="text-align: center; font-size: 11px; color: var(--text-dim);">${item.type}</td>
                    <td class="amount-col">${formatLKR(item.cost)}</td>
                `;
                reviewTableBody.appendChild(row);
            });
        }
        if (reviewGrandTotal) reviewGrandTotal.textContent = formatLKR(grandTotal);
    }

    function selectVenueCard(venueName, cardId) {
        const input = document.getElementById('place');
        if (cardId === 'venue_custom') {
            if (!input.value || input.value === 'Shangri-La Colombo' || input.value === 'Cinnamon Grand Colombo' || input.value.includes('Kingsbury') || input.value.includes('Jetwing') || input.value.includes("Earl's")) {
                input.value = '';
            }
            input.focus();
        } else {
            input.value = venueName;
        }

        document.querySelectorAll('.venue-card').forEach(c => c.classList.remove('selected'));
        const selectedCard = document.getElementById(cardId);
        if (selectedCard) selectedCard.classList.add('selected');

        syncDossierReview();
    }

    function onCustomVenueInput(val) {
        let matched = false;
        document.querySelectorAll('.venue-card').forEach(c => {
            const titleEl = c.querySelector('div[style*="font-weight: 800"]');
            if (titleEl && titleEl.textContent.trim().toLowerCase() === val.trim().toLowerCase()) {
                c.classList.add('selected');
                matched = true;
            } else {
                c.classList.remove('selected');
            }
        });

        if (!matched) {
            const customCard = document.getElementById('venue_custom');
            if (customCard) customCard.classList.add('selected');
        }
        syncDossierReview();
    }

    function validateAndGoStage(targetStage) {
        if (targetStage === 2) {
            const couple = document.getElementById('couple_names');
            const date   = document.getElementById('event_date');
            const email  = document.getElementById('contact_email');
            const phone  = document.getElementById('contact_phone');

            if (!couple.value.trim()) {
                alert("Please enter the celebrants' full names.");
                couple.focus();
                return;
            }
            if (!email.value.trim() || !email.checkValidity()) {
                alert("Please provide a valid contact email address.");
                email.focus();
                return;
            }
            if (!phone.value.trim()) {
                alert("Please provide a contact phone number.");
                phone.focus();
                return;
            }
            if (!date.value) {
                alert("Please select a valid wedding date.");
                date.focus();
                return;
            }
        } else if (targetStage === 3) {
            const place = document.getElementById('place');
            if (!place.value.trim()) {
                alert("Please select or enter your banquet hall or destination venue.");
                place.focus();
                return;
            }
        }
        navigateToStage(targetStage);
    }

    function navigateToStage(stage) {
        if (stage < 1 || stage > 4) return;
        currentStage = stage;

        for (let i = 1; i <= 4; i++) {
            const pane = document.getElementById('stage' + i);
            if (pane) pane.classList.toggle('active', i === stage);

            const node = document.getElementById('stepNode' + i);
            if (node) {
                node.classList.toggle('active', i === stage);
                node.classList.toggle('completed', i < stage);
            }
        }

        const stepperFill = document.getElementById('stepperFill');
        if (stepperFill) {
            const percentages = [0, 0, 33.33, 66.66, 100];
            stepperFill.style.width = percentages[stage] + '%';
        }

        if (stage === 4) {
            syncDossierReview();
        }

        const header = document.querySelector('.wizard-header');
        if (header) {
            header.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function syncDossierReview() {
        const coupleNames = document.getElementById('couple_names')?.value.trim() || 'Honored Couple';
        const contactPhone = document.getElementById('contact_phone')?.value.trim() || 'Not provided';
        const contactEmail = document.getElementById('contact_email')?.value.trim() || 'Not provided';
        const place       = document.getElementById('place')?.value.trim() || 'Selected Venue';
        const eventDate   = document.getElementById('event_date')?.value || 'Pending Date';
        const sessionRadio = document.querySelector('input[name="DayNight"]:checked');
        const session     = sessionRadio ? sessionRadio.value : 'Night';
        const guestsInput = document.getElementById('number_of_guests');
        const guests      = guestsInput ? Math.max(20, parseInt(guestsInput.value) || 20) : 150;
        const styleRadio  = document.querySelector('input[name="cultural_style"]:checked');
        const style       = styleRadio ? styleRadio.value : 'Traditional';
        const tierRadio   = document.querySelector('input[name="catering_tier"]:checked');
        const tierName    = tierRadio ? tierRadio.value : 'Executive';
        const tierRate    = tierRadio ? parseFloat(tierRadio.getAttribute('data-rate') || 4800) : 4800;
        const cateringSubtotal = guests * tierRate;
        const equipment   = document.getElementById('equipment')?.value.trim() || 'None specified (Standard Ballroom AV)';
        const extraNotes  = document.getElementById('ExtraDetails')?.value.trim() || 'Standard itinerary without special dietary partitions.';

        // Update Dossier Fields
        const revCouple = document.getElementById('revCoupleNames');
        if (revCouple) revCouple.textContent = coupleNames;

        const revPhone = document.getElementById('revContactPhone');
        if (revPhone) revPhone.textContent = contactPhone;

        const revEmail = document.getElementById('revContactEmail');
        if (revEmail) revEmail.textContent = contactEmail;

        const revVenue = document.getElementById('revVenue');
        if (revVenue) revVenue.textContent = place;

        const revDate = document.getElementById('revEventDate');
        if (revDate) revDate.textContent = eventDate;

        const revSession = document.getElementById('revSessionTiming');
        if (revSession) revSession.textContent = (session === 'Day' ? 'Daytime Auspicious (09:00 - 15:30)' : 'Starlight Evening Gala (17:30 - 23:45)');

        const revHead = document.getElementById('revHeadcount');
        if (revHead) revHead.textContent = `${guests} Attendees`;

        const revStyle = document.getElementById('revStyle');
        if (revStyle) revStyle.textContent = `${style} Nuptial Style`;

        const revTier = document.getElementById('revCateringTier');
        if (revTier) revTier.textContent = `${tierName} Royal Tier`;

        const revRate = document.getElementById('revCateringRate');
        if (revRate) revRate.textContent = `${formatLKR(tierRate)} per guest`;

        const revCatSub = document.getElementById('revCateringSubtotal');
        if (revCatSub) revCatSub.textContent = formatLKR(cateringSubtotal);

        const revEquip = document.getElementById('revEquipment');
        if (revEquip) revEquip.textContent = equipment;

        const revNotes = document.getElementById('revExtraNotes');
        if (revNotes) revNotes.textContent = extraNotes;

        // Populate Selected Artisans in Dossier
        const artisansList = document.getElementById('revArtisansList');
        if (artisansList) {
            artisansList.innerHTML = '';
            let count = 0;
            const packageRadios = document.querySelectorAll('input[name^="selected_packages"]:checked');
            packageRadios.forEach(radio => {
                const unitPrice = parseFloat(radio.getAttribute('data-unit-price') || 0);
                const priceType = radio.getAttribute('data-type') || 'total_package';
                const pkgName   = radio.getAttribute('data-name') || '';
                const vendor    = radio.getAttribute('data-vendor') || '';

                if (radio.value && unitPrice > 0) {
                    count++;
                    let cost = unitPrice;
                    let typeBadge = 'Flat Package';
                    if (priceType === 'per_person') {
                        cost = unitPrice * guests;
                        typeBadge = `${guests} × LKR ${unitPrice.toLocaleString()}`;
                    }

                    const li = document.createElement('li');
                    li.style.cssText = 'background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 8px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; gap: 12px;';
                    li.innerHTML = `
                        <div>
                            <div style="font-weight: 700; font-size: 13px; color: #fff;">
                                <i class="fas fa-certificate" style="color: #a78bfa; margin-right: 6px;"></i> ${pkgName}
                            </div>
                            <small style="color: #94a3b8; font-size: 11px;">Vendor: ${vendor} • <span style="color: #c4b5fd;">${typeBadge}</span></small>
                        </div>
                        <div style="font-weight: 800; color: #38bdf8; font-size: 13px; white-space: nowrap;">
                            ${formatLKR(cost)}
                        </div>
                    `;
                    artisansList.appendChild(li);
                }
            });

            if (count === 0) {
                const li = document.createElement('li');
                li.style.cssText = 'color: var(--text-dim); font-size: 12px; font-style: italic; padding: 6px 0;';
                li.textContent = 'No additional specialized third-party artisans selected.';
                artisansList.appendChild(li);
            }
        }

        recalculateTotals();
    }

    document.addEventListener('DOMContentLoaded', () => {
        recalculateTotals();
        updateStyleCard();
        updateTierCard();
        updateSessionCard();
    });
</script>

@else
{{-- =========================================================================
     STANDARD UNIVERSAL CATEGORY BOOKING ENGINE (Birthdays, DJ Parties, etc.)
========================================================================= --}}
<div style="max-width: 1100px; margin: 40px auto 80px; padding: 0 24px;">

    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 40px; align-items: start;">
        <!-- Left: Form Container -->
        <div class="glass-card" style="padding: 35px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-bottom: 12px;">
                <i class="fas fa-calendar-plus"></i> Guaranteed Booking Engine
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: var(--text-heading); margin-bottom: 8px;">
                Book Your Celebration
            </h1>
            <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 25px;">
                Directly configure your dates, venue, guest numbers, and food preference tier.
            </p>

            <!-- Dynamic Category Wizard Banner -->
            @if(stripos($preEvent, 'DJ') !== false || stripos($preEvent, 'Party') !== false)
                <div style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(6, 182, 212, 0.08)); border: 1px solid rgba(139, 92, 246, 0.3); border-radius: 14px; padding: 16px 18px; margin-bottom: 24px;">
                    <strong style="color: var(--primary); font-size: 14px; display: block; margin-bottom: 2px;"><i class="fas fa-bolt"></i> Intelligent Sound & Club Visuals Active</strong>
                    <span style="font-size: 12px; color: var(--text-muted);">High-output lighting rigs, pro audio stacks, and headline DJ packages available below.</span>
                </div>
            @elseif(stripos($preEvent, 'Birth') !== false)
                <div style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(244, 63, 94, 0.08)); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 14px; padding: 16px 18px; margin-bottom: 24px;">
                    <strong style="color: #d97706; font-size: 14px; display: block; margin-bottom: 2px;"><i class="fas fa-birthday-cake"></i> Milestone Birthday Celebration Selected</strong>
                    <span style="font-size: 12px; color: var(--text-muted);">Custom 3D fondant cakes, balloon arch stylists, and interactive magicians ready below.</span>
                </div>
            @elseif(stripos($preEvent, 'Hotel') !== false || stripos($preEvent, 'Venue') !== false)
                <div style="background: linear-gradient(135deg, rgba(217, 119, 6, 0.15), rgba(71, 85, 105, 0.08)); border: 1px solid rgba(217, 119, 6, 0.3); border-radius: 14px; padding: 16px 18px; margin-bottom: 24px;">
                    <strong style="color: #d97706; font-size: 14px; display: block; margin-bottom: 2px;"><i class="fas fa-hotel"></i> Five-Star Hotel Venue & Ballroom Coordination</strong>
                    <span style="font-size: 12px; color: var(--text-muted);">Grand ballroom slots, in-house plated menus, and executive AV podiums loaded below.</span>
                </div>
            @elseif(stripos($preEvent, 'Together') !== false || stripos($preEvent, 'Reunion') !== false)
                <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(13, 148, 136, 0.08)); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 14px; padding: 16px 18px; margin-bottom: 24px;">
                    <strong style="color: #059669; font-size: 14px; display: block; margin-bottom: 2px;"><i class="fas fa-handshake"></i> Social Mixer & Lawn BBQ Setup</strong>
                    <span style="font-size: 12px; color: var(--text-muted);">Live charcoal BBQ master grills, marquee canopies, and sing-along acoustic sets available below.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('booking.store') }}">
                @csrf

                <!-- Customer Read-Only Badge -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <small style="color: var(--text-muted); font-size: 11px; font-weight: 700; text-transform: uppercase;">Logged In Client</small>
                        <div style="font-weight: 800; font-size: 14px; color: var(--text-heading);">
                            {{ Auth::user()->fullname ?? Auth::user()->username }} ({{ Auth::user()->email }})
                        </div>
                    </div>
                    <span style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 10px;">
                        <i class="fas fa-shield-alt"></i> Verified Account
                    </span>
                </div>

                <!-- Event Type & Venue -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label class="form-label" for="EventType">Event Category <span style="color:#ef4444;">*</span></label>
                        <select id="EventType" class="form-input" name="EventType" required>
                            <option value="">Select category</option>
                            @foreach ($eventTypes as $type)
                                <option value="{{ $type->type_name }}" {{ (strcasecmp($preEvent, $type->type_name) === 0 || old('EventType') === $type->type_name) ? 'selected' : '' }}>
                                    {{ $type->type_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('EventType') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label" for="Place">Venue / City Location <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="Place" class="form-input" placeholder="e.g. Shangri-La Colombo or Kandy" name="Place" 
                               value="{{ old('Place', $preVenue) }}" required>
                        @error('Place') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Guests & Date -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label class="form-label" for="NumberOfGuests">Expected Guests <span style="color:#ef4444;">*</span></label>
                        <input type="number" id="NumberOfGuests" class="form-input" placeholder="e.g. 150" name="NumberOfGuests" min="1" max="50000"
                               value="{{ old('NumberOfGuests', $preGuests > 0 ? $preGuests : 100) }}" required>
                        @error('NumberOfGuests') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label" for="EventDate">Reservation Date <span style="color:#ef4444;">*</span></label>
                        <input type="date" id="EventDate" class="form-input" name="EventDate" min="{{ date('Y-m-d') }}"
                               value="{{ old('EventDate') }}" required>
                        @error('EventDate') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Day/Night Session & Food Tier -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label class="form-label" for="DayNight">Session Timing <span style="color:#ef4444;">*</span></label>
                        <select id="DayNight" class="form-input" name="DayNight" required>
                            <option value="">Select session</option>
                            <option value="Day" {{ old('DayNight') === 'Day' ? 'selected' : '' }}>Day Session (Morning/Afternoon)</option>
                            <option value="Night" {{ old('DayNight') === 'Night' ? 'selected' : '' }}>Night Session (Evening Gala)</option>
                        </select>
                        @error('DayNight') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="form-label" for="FoodPreferences">Catering Tier <span style="color:#ef4444;">*</span></label>
                        <select id="FoodPreferences" class="form-input" name="FoodPreferences" required>
                            <option value="">Select pricing tier</option>
                            <option value="High price" {{ old('FoodPreferences') === 'High price' ? 'selected' : '' }}>High Tier (Luxury Buffet & Live Stations)</option>
                            <option value="Middle price" {{ old('FoodPreferences') === 'Middle price' ? 'selected' : '' }}>Medium Tier (Standard 3-Course Buffet)</option>
                            <option value="Low Price" {{ old('FoodPreferences') === 'Low Price' ? 'selected' : '' }}>Economy Tier (Light Refreshments & Starters)</option>
                        </select>
                        <a href="{{ route('food-calculator') }}" target="_blank" style="font-size: 12px; color: var(--primary); font-weight: 600; display: inline-block; margin-top: 4px;">
                            <i class="fas fa-calculator"></i> Open Food Calculator
                        </a>
                        @error('FoodPreferences') <span style="color:#ef4444; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Event Extra Equipment / Staging -->
                <div style="margin-bottom: 18px;">
                    <label class="form-label" for="equipment">Stage & AV Production Needs (Optional)</label>
                    <input type="text" id="equipment" class="form-input" name="equipment" 
                           placeholder="e.g. Ambient floral arch, wireless handheld mics, LED mood wash"
                           value="{{ old('equipment') }}">
                </div>

                <!-- Special Instructions -->
                <div style="margin-bottom: 24px;">
                    <label class="form-label" for="ExtraDetails">Special Notes & Itinerary Requests</label>
                    <textarea id="ExtraDetails" class="form-input" style="height: 90px; resize: vertical;" name="ExtraDetails" 
                              placeholder="Any dietary restrictions, theme colors, VIP requests, or specific vendor preferences...">{{ old('ExtraDetails', $preDetails) }}</textarea>
                </div>

                <!-- Itemized Vendor Packages (if applicable) -->
                @if($services->isNotEmpty())
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; margin-bottom: 24px;">
                        <h4 style="font-size: 15px; font-weight: 800; color: var(--text-heading); margin-bottom: 14px;">
                            <i class="fas fa-tags" style="color: var(--primary); margin-right: 6px;"></i> Optional Handpicked Vendor Add-Ons
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach($services as $srv)
                                @if($srv->listings->isNotEmpty())
                                    <div>
                                        <label style="font-size: 12px; font-weight: 700; color: var(--text-heading); display: block; margin-bottom: 4px;">
                                            {{ $srv->service_name }}
                                        </label>
                                        <select name="selected_packages[{{ $srv->service_id }}]" class="form-input" style="font-size: 13px;">
                                            <option value="">No vendor add-on (Default coordination)</option>
                                            @foreach($srv->listings as $pkg)
                                                <option value="{{ $pkg->listing_id }}">
                                                    {{ $pkg->supplier->business_name }}: {{ $pkg->title }} — LKR {{ number_format($pkg->price) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; border-radius: 30px; font-size: 15px; font-weight: 800;">
                    <i class="fas fa-check-circle"></i> Confirm & Secure Event Reservation
                </button>
            </form>
        </div>

        <!-- Right: Showcase & Assurance Sidecard -->
        <div>
            <div style="position: sticky; top: 100px; display: flex; flex-direction: column; gap: 20px;">
                <div class="glass-card" style="padding: 26px; border-radius: 20px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text-heading); margin-bottom: 14px;">
                        <i class="fas fa-award" style="color: #f59e0b; margin-right: 6px;"></i> Why Book with EVENTFLARE?
                    </h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px; font-size: 13px; color: var(--text-muted);">
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-top: 2px;"></i>
                            <span><strong>100% Accredited Suppliers:</strong> Every caterer, decorator, and sound engineer is vetted.</span>
                        </li>
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-top: 2px;"></i>
                            <span><strong>Transparent Pricing:</strong> No surprise fees; clear itemized estimates in Sri Lankan Rupees.</span>
                        </li>
                        <li style="display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-top: 2px;"></i>
                            <span><strong>Instant Itinerary PDF:</strong> Receive your formal confirmation slip immediately upon booking.</span>
                        </li>
                    </ul>
                </div>

                <div style="border-radius: 20px; overflow: hidden; height: 260px; position: relative; box-shadow: var(--shadow-premium);">
                    <img src="{{ asset('assets/images/evnt.jpg') }}" alt="Event Celebration" 
                         style="width: 100%; height: 100%; object-fit: cover;"
                         onerror="this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800'">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(10,8,19,0.85), transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 20px; color: #fff;">
                        <h4 style="font-size: 18px; font-weight: 800; margin: 0 0 4px;">Unforgettable Moments</h4>
                        <p style="font-size: 12px; color: rgba(255,255,255,0.8); margin: 0;">Tailored celebrations across Sri Lanka from concept to completion.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endif

@endsection
