@extends('layouts.eventflare')

@section('title', 'Terms of Service — EVENTFLARE')

@section('content')
<div style="max-width: 960px; margin: 0 auto; padding: 50px 24px;">
    <!-- Breadcrumb & Header -->
    <div style="margin-bottom: 36px;">
        <span style="background: rgba(139, 92, 246, 0.1); color: var(--primary); font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
            Legal Agreement
        </span>
        <h1 style="font-size: 36px; font-weight: 900; color: var(--text-heading); margin-top: 12px; margin-bottom: 10px;">
            Terms of Service
        </h1>
        <p style="color: var(--text-muted); font-size: 14px;">
            Effective Date: September 16, 2026 &bull; Applicable across the Democratic Socialist Republic of Sri Lanka
        </p>
    </div>

    <!-- Content Card -->
    <div class="glass-card" style="padding: 40px; border-radius: 20px; line-height: 1.8; color: #334155;">
        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 0; margin-bottom: 12px;">
            1. Acceptance of Terms
        </h2>
        <p>
            By accessing or using the EVENTFLARE digital platform ("Platform"), available via web and mobile interfaces, you agree to be bound by these Terms of Service ("Terms") and our Privacy Policy. If you do not agree to all terms and conditions, you must discontinue using our services immediately.
        </p>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            2. Platform Description & Role
        </h2>
        <p>
            EVENTFLARE operates an intelligent event planning and vendor coordination marketplace connecting event hosts ("Clients" or "Buyers") with verified third-party suppliers, venues, caterers, photographers, and audio-visual technicians ("Suppliers"). 
        </p>
        <p>
            EVENTFLARE serves as an intermediary platform facilitating event discovery, scheduling, and logistical coordination. Contracts for specific services and items are entered into directly between Clients and accredited Suppliers.
        </p>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            3. User Accounts & Registration
        </h2>
        <p>
            To submit bookings or list vendor packages, users must register an account. You agree to:
        </p>
        <ul style="padding-left: 20px; margin-bottom: 16px;">
            <li>Provide accurate, current, and complete registration credentials.</li>
            <li>Maintain the confidentiality of your password and account session.</li>
            <li>Immediately notify our concierge desk of any unauthorized account activity.</li>
            <li>Take full responsibility for all activities occurring under your authenticated credentials.</li>
        </ul>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            4. Booking Reservations & Payment Policies
        </h2>
        <p>
            All event reservations made through the Platform are subject to vendor confirmation and capacity availability.
        </p>
        <ul style="padding-left: 20px; margin-bottom: 16px;">
            <li><strong>Pricing:</strong> All catalog prices are displayed in Sri Lankan Rupees (LKR) and reflect standard package specifications.</li>
            <li><strong>Modifications:</strong> Changes to guest headcount or scheduled dates must be submitted at least 14 working days prior to the event date.</li>
            <li><strong>Direct Settlement:</strong> In the current operational phase, final balances are settled via verified invoice transfers directly between event hosts and vendors.</li>
        </ul>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            5. Supplier Conduct & Accreditations
        </h2>
        <p>
            Vendors registered on EVENTFLARE represent that they hold all required provincial business registrations, public liability coverage, and health hygiene permits applicable under Sri Lankan law. Any vendor found misrepresenting credentials or failing to deliver confirmed engagements will be permanently de-listed.
        </p>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            6. Limitation of Liability
        </h2>
        <p>
            To the maximum extent permitted by applicable laws of Sri Lanka, EVENTFLARE and its operators shall not be held liable for indirect, incidental, punitive, or consequential damages arising from vendor cancellations, inclement weather conditions, power outages, or venue disputes.
        </p>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            7. Governing Law & Jurisdiction
        </h2>
        <p>
            These Terms shall be governed by and construed in accordance with the laws of the Democratic Socialist Republic of Sri Lanka. Any disputes arising hereunder shall be subject to the exclusive jurisdiction of the competent courts of Colombo, Sri Lanka.
        </p>

        <div style="margin-top: 36px; padding-top: 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
            <span style="font-size: 13px; color: var(--text-muted);">Have questions regarding these terms?</span>
            <a href="{{ route('home') }}#contact" class="btn btn-outline" style="font-size: 13px; border-radius: 10px; border: 1px solid var(--primary); text-decoration: none;">
                <i class="fas fa-envelope"></i> Contact Legal Desk
            </a>
        </div>
    </div>
</div>
@endsection
