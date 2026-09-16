@extends('layouts.eventflare')

@section('title', 'About Us — EVENTFLARE')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding: 50px 24px;">
    <div style="text-align: center; margin-bottom: 50px;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(139, 92, 246, 0.1); color: var(--primary); padding: 6px 16px; border-radius: 30px; font-size: 13px; font-weight: 700; margin-bottom: 14px;">
            <i class="fas fa-gem"></i> The Eventflare Vision
        </div>
        <h1 style="font-size: 40px; font-weight: 900; color: var(--text-heading); margin-bottom: 14px;">About EVENTFLARE</h1>
        <p style="color: var(--text-muted); font-size: 17px; max-width: 700px; margin: 0 auto; line-height: 1.7;">
            Sri Lanka’s premier dual-sided celebration marketplace, empowering families and businesses to plan, budget, and execute flawless events with accredited professionals.
        </p>
    </div>

    <div class="glass-card" style="margin-bottom: 40px; padding: 40px;">
        <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 14px; color: var(--text-heading);">Our Story</h2>
        <p style="color: var(--text-muted); line-height: 1.8; font-size: 15px; margin-bottom: 20px;">
            Planning an event in Sri Lanka has historically required weeks of phone calls, ambiguous pricing, unverified vendor portfolios, and manual spreadsheets. EVENTFLARE was built to replace that uncertainty with absolute clarity.
        </p>
        <p style="color: var(--text-muted); line-height: 1.8; font-size: 15px;">
            By integrating itemized service catalogs, accredited supplier listings, verified client reviews, real-time budget calculation, and digital booking dossiers, we ensure that every milestone — from a traditional Poruwa ceremony to an EDM concert night — is executed with precision.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 50px;">
        <div class="glass-card">
            <div style="font-size: 28px; color: var(--primary); margin-bottom: 14px;"><i class="fas fa-shield-alt"></i></div>
            <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">Vetted Quality</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6;">Every vendor on EVENTFLARE undergoes portfolio validation, equipment inspection, and service-level agreement compliance.</p>
        </div>
        <div class="glass-card">
            <div style="font-size: 28px; color: #ec4899; margin-bottom: 14px;"><i class="fas fa-tags"></i></div>
            <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">Transparent Pricing</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6;">No hidden fees or unexpected post-event surcharges. All package costs and per-head rates are clearly documented.</p>
        </div>
        <div class="glass-card">
            <div style="font-size: 28px; color: #059669; margin-bottom: 14px;"><i class="fas fa-file-invoice"></i></div>
            <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">Unified Dossier</h3>
            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.6;">One central dashboard for your venue bookings, catering budgets, and PDF itinerary exports.</p>
        </div>
    </div>
</div>
@endsection