# EVENTFLARE — Enterprise Event Planning & Management Platform

[![CI/CD Pipeline](https://github.com/prasajanravishka/Event-Planning-Management/actions/workflows/ci.yml/badge.svg)](https://github.com/prasajanravishka/Event-Planning-Management/actions)
[![Laravel LTS](https://img.shields.io/badge/Laravel-10.x_LTS-FF2D20.svg?logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20%7C%208.2-777BB4.svg?logo=php)](https://php.net)
[![Compliance](https://img.shields.io/badge/Compliance-Sri%20Lanka%20PDPA-059669.svg)](/privacy)
[![Tests Passing](https://img.shields.io/badge/Tests-74%20Passed-success.svg)](/tests)

**EVENTFLARE** is an industrial-grade event planning and supplier coordination marketplace designed for Sri Lanka. It connects event hosts with verified vendors (traditional Kandyan Poruwa artisans, stage sound engineers, DJs, luxury banquet hotels, and wedding photographers) with transparent package pricing and end-to-end booking workflows.

---

## Architecture Overview

EVENTFLARE was completely re-architected from legacy vanilla PHP into a modern **Laravel 10 LTS MVC** architecture:

```text
eventflare/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Executive command center, catalog, moderation
│   │   │   ├── Auth/            # Breeze auth with multi-role redirection & auditing
│   │   │   ├── Client/          # Booking creation, client hub, PDF exports
│   │   │   ├── Supplier/        # Vendor dashboard, service sync, package CRUD
│   │   │   ├── MarketplaceController.php # Full-text search & price filter engine
│   │   │   ├── PageController.php        # Marketing showcase, contact desk, legal
│   │   │   └── EventShowcaseController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php       # Enforces admin role isolation
│   │       ├── SupplierMiddleware.php    # Vendor-only access control
│   │       ├── BuyerMiddleware.php       # Client-only access control
│   │       ├── SecurityHeadersMiddleware.php # CSP, XSS, Sniff, Frame headers
│   │       └── InactivityTimeoutMiddleware.php # Session timeout security
│   ├── Mail/                           # Mailable classes for notifications
│   │   ├── BookingConfirmationMail.php
│   │   ├── BookingStatusUpdatedMail.php
│   │   ├── NewContactInquiryMail.php
│   │   └── SupplierAssignedMail.php
│   └── Models/                         # 12 Eloquent domain models with cascades
├── database/migrations/                # 15 Relational migrations with FK constraints
├── resources/views/                    # Blade views with Glassmorphism UI tokens
└── tests/Feature/                      # Comprehensive PHPUnit/Pest automated test suite
```

---

## Quick Start & Installation

### 1. Prerequisites
- **PHP** $\ge$ 8.1 (with `pdo_mysql`, `mbstring`, `fileinfo`, `gd`, `openssl` extensions enabled)
- **Composer** $\ge$ 2.5
- **MySQL / MariaDB** (via XAMPP or standalone server)

### 2. Setup Project
```powershell
cd d:\Projects\eventflare
composer install
copy .env.example .env
php artisan key:generate
```

### 3. Database Migration & Seed
Ensure your MySQL database `eventflare` exists, then populate all relational tables and realistic demo data:
```powershell
php artisan migrate --seed
```

### 4. Link Public Storage
Enable public access for uploaded supplier logos and package photos:
```powershell
php artisan storage:link
```

### 5. Launch Development Server
```powershell
php artisan serve
```
Open **[http://127.0.0.1:8000](http://127.0.0.1:8000)** in your browser.

---

## Seeded Test Accounts

| Role | Username | Password | Purpose |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin` | `admin123` | Executive metrics, booking approvals, review moderation, staff provisioning |
| **Supplier** | `soundmaster` | `password123` | Vendor dashboard, service accreditation sync, package management |
| **Buyer / Client** | `john_doe` | `password123` | Client event hub, booking submission wizard, PDF reservation dossier |

---

## Platform Features

1. **Multi-Role Security**:
   - Strict role-based middleware (`admin`, `supplier`, `buyer`).
   - Rate-limited login attempts with IP tracking in `login_attempts` audit table.
   - Global HTTP security headers (`X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`).

2. **Supplier Directory & Package Marketplace**:
   - Keyword search across package titles, descriptions, and trade specialities.
   - Category filtering (Weddings, DJ Parties, Birthdays, Hotel Venues, Get-Togethers).
   - Regional location filtering (Colombo, Kandy, Galle).
   - Price range slider / min-max filters in Sri Lankan Rupees (LKR).

3. **Booking Lifecycle & PDF Export**:
   - Multi-event reservation wizard factoring guest count, daytime/night, and food profiles.
   - Automated PDF Dossier generation via `barryvdh/laravel-dompdf`.

4. **Industrial Email Notifications**:
   - Automated triggers for booking confirmations, status alterations, admin inquiries, and vendor assignments.

5. **File Upload System**:
   - Secure image handling using PHP `gd` for brand logos and package gallery images.

6. **Legal & Compliance**:
   - Terms of Service enforceable under Sri Lankan civil law.
   - Privacy Policy strictly compliant with the **Sri Lanka Personal Data Protection Act (PDPA) No. 9 of 2022**.
   - Responsive Cookie Consent banner with `localStorage` persistence.

---

## Automated Test Suite

Run the full automated test suite containing **74 feature and unit tests**:
```powershell
php artisan test
```

All 74 tests pass 100% green with 224 assertions covering authentication, authorization boundaries, client bookings, supplier management, admin operations, file uploads, email dispatches, search filters, and legal views.

---

## License
The EVENTFLARE platform is open-sourced software licensed under the [MIT License](LICENSE).


If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
