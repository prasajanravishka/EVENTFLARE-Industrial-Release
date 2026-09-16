@extends('layouts.eventflare')

@section('title', 'Privacy Policy & Data Protection — EVENTFLARE')

@section('content')
<div style="max-width: 960px; margin: 0 auto; padding: 50px 24px;">
    <!-- Breadcrumb & Header -->
    <div style="margin-bottom: 36px;">
        <span style="background: rgba(16, 185, 129, 0.1); color: #059669; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
            <i class="fas fa-shield-alt"></i> Sri Lanka PDPA Compliant
        </span>
        <h1 style="font-size: 36px; font-weight: 900; color: var(--text-heading); margin-top: 12px; margin-bottom: 10px;">
            Privacy Policy & Data Protection
        </h1>
        <p style="color: var(--text-muted); font-size: 14px;">
            In accordance with the <strong>Personal Data Protection Act (PDPA) No. 9 of 2022</strong> of Sri Lanka &bull; Last Revised: September 2026
        </p>
    </div>

    <!-- Content Card -->
    <div class="glass-card" style="padding: 40px; border-radius: 20px; line-height: 1.8; color: #334155;">
        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 0; margin-bottom: 12px;">
            1. Commitment to Personal Data Protection
        </h2>
        <p>
            EVENTFLARE is dedicated to protecting the confidentiality and integrity of your personal information. As an event technology provider operating within Sri Lanka, our data processing protocols comply with the statutory principles established under the <em>Personal Data Protection Act, No. 9 of 2022</em> (PDPA).
        </p>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            2. Categories of Information We Collect
        </h2>
        <p>
            We process only such data as is necessary to facilitate event coordination and vendor delivery:
        </p>
        <ul style="padding-left: 20px; margin-bottom: 16px;">
            <li><strong>Account Identity:</strong> Full name, telephone number, email address, physical billing address.</li>
            <li><strong>Event Specifications:</strong> Occasion date, guest count, venue coordinates, dietary requirements, and bespoke poruwa/entertainment instructions.</li>
            <li><strong>Supplier Profiles:</strong> Business registration names, accreditation certificates, portfolio media, and regional dispatch radius.</li>
            <li><strong>Technical Telemetry:</strong> Anonymized session logs, device types, and IP addresses captured strictly for fraud defense and rate limiting.</li>
        </ul>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            3. Lawful Basis and Purpose of Processing
        </h2>
        <p>
            Under Section 5 of the PDPA, your data is processed exclusively under the lawful basis of:
        </p>
        <ul style="padding-left: 20px; margin-bottom: 16px;">
            <li><strong>Contractual Performance:</strong> Enabling booking dispatch, vendor coordination, and reservation confirmation.</li>
            <li><strong>Legitimate Interests:</strong> Preventing fraudulent bookings, moderating customer reviews, and optimizing system uptime.</li>
            <li><strong>Explicit Consent:</strong> Sending non-essential event inspirations or updates when requested.</li>
        </ul>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            4. Data Sharing & Third Parties
        </h2>
        <p>
            EVENTFLARE does not sell, lease, or monetize user data to marketing aggregators. Information is shared only with:
        </p>
        <ul style="padding-left: 20px; margin-bottom: 16px;">
            <li><strong>Assigned Suppliers:</strong> Disclosing event dates and venue requirements strictly to fulfill your confirmed booking.</li>
            <li><strong>Regulatory Authorities:</strong> Where mandated by court orders or Sri Lankan statutory laws.</li>
        </ul>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            5. Your Statutory Rights as a Data Subject
        </h2>
        <p>
            Under Part II of the Sri Lanka PDPA, you retain clear enforceable rights:
        </p>
        <ul style="padding-left: 20px; margin-bottom: 16px;">
            <li><strong>Right of Access:</strong> Request a copy of your personal data held in our active registries.</li>
            <li><strong>Right to Rectification:</strong> Edit and correct outdated details directly via your authenticated client profile.</li>
            <li><strong>Right to Erasure / Account Deletion:</strong> Permanently delete your user account and historical logs through the profile management console.</li>
            <li><strong>Right to Withdraw Consent:</strong> Revoke consent for non-essential notices at any time.</li>
        </ul>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            6. Security Measures & Encryption
        </h2>
        <p>
            All data in transit is protected using TLS 1.3 encryption. Passwords are salted and hashed utilizing the industry-standard bcrypt cipher. In accordance with Section 21 of the PDPA, technical and organizational safeguards are continuously enforced to prevent accidental data loss or unauthorized access.
        </p>

        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-heading); margin-top: 30px; margin-bottom: 12px;">
            7. Data Protection Officer (DPO) Contact
        </h2>
        <p>
            If you wish to exercise your data protection rights or make a privacy inquiry, you may contact our designated Data Protection Officer:
        </p>
        <p style="margin-bottom: 0;">
            <strong>Data Protection Officer</strong><br>
            EVENTFLARE Operations &bull; Colombo 03, Western Province, Sri Lanka<br>
            Email: <a href="mailto:dpo@eventflare.lk" style="color: var(--primary); font-weight: 700;">dpo@eventflare.lk</a>
        </p>
    </div>
</div>
@endsection
