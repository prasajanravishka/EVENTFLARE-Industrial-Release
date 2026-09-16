# Changelog

All notable changes to the **EVENTFLARE** platform are documented in this file.

## [1.0.0-beta] - 2026-09-16

### Added
- **Laravel 10 Architecture**: Complete migration from legacy procedural PHP to Laravel LTS MVC.
- **Relational Migrations**: 15 database tables with foreign key cascades, proper primary keys, and indexing.
- **Multi-Role Security**: Breeze authentication enhanced with custom roles (`admin`, `supplier`, `buyer`), brute-force throttling, and `login_attempts` auditing.
- **Security Headers & Inactivity Timeout**: Global middleware injecting CSP, X-Frame-Options, and 2-hour session expirations.
- **Dynamic Marketplace**: Search and filter engine supporting keyword search, event types, price ranges in LKR, regional cities, and ordering.
- **File Upload System**: Automated storage disk integration for vendor brand logos and package gallery media using PHP `gd`.
- **Transactional Notifications**: Mailable classes and Markdown templates for booking confirmations, status updates, contact desk inquiries, and supplier assignments.
- **Client & Supplier Portals**: Dedicated executive dashboards, booking wizards, PDF reservation dossier exports, and package CRUD.
- **Administrative Command Center**: Comprehensive moderation for reviews, bookings, users, supplier catalog, budgets, and staff.
- **Sri Lanka PDPA Compliance**: Terms of Service and Privacy Policy adhering to Personal Data Protection Act No. 9 of 2022, with cookie consent banner.
- **CI/CD Automation**: GitHub Actions workflow verifying migrations, seeders, and automated tests across PHP 8.1 and 8.2.

### Security
- Eliminated SQL injection vulnerabilities by migrating all raw queries to Eloquent ORM and prepared PDO statements.
- Eliminated cross-site scripting (XSS) via Blade auto-escaping syntax.
- Enforced CSRF tokens on all POST/PUT/PATCH/DELETE endpoints.
- Removed plaintext password handling in favor of bcrypt password hashing.

### Tests
- 74 automated feature and unit tests with 224 assertions running 100% green.
