# Temporary Pass Application System
Project Overview

This is a Laravel 12 application designed to streamline the management of temporary campus passes, guest records, and security staff workflows. The system provides a digital solution for issuing and verifying temporary access passes, replacing manual logbooks with a more secure and efficient process.

Key Features:

University Member Portal: Secure login for students and staff using their existing university credentials (simulated via an external AMS database).

Guest Access: A public-facing portal for visitors to request temporary passes.

Admin Dashboard: A centralized hub for administrators to review, approve, or reject pass applications.

Security Portal: A dedicated interface for security guards to verify QR codes and check pass validity in real-time.

QR Code Integration: Automatic generation of secure QR codes for approved passes.

Email Notifications: Automated emails for application receipts, approvals, and rejections.


# Pass Approval Workflows

The system implements distinct workflows for different user types to balance security and convenience:

1. University Members (Automated)

Submission: Members log in via AMS credentials and submit a request (e.g., for a lost ID card).

Validation: The system performs an automatic check for abuse (e.g., preventing a member from requesting a "Lost ID" pass more than once within 30 days).

Outcome:

Success: If the request meets criteria, the pass is automatically approved instantly. A QR code is generated and emailed to the member immediately.

Rate Limited: If the member has exceeded the request limit for specific reasons, the system auto-rejects the request and instructs them to visit the security office physically for manual processing.

2. Guests (Manual)

Submission: Visitors apply via the public portal, providing their details, reason for visit, and a profile photo.

Queue: The request enters a Pending state and is queued on the Admin Dashboard.

Review: An administrator reviews the application details and reason.

Outcome:

Approval: When an admin clicks approve, the system generates a QR code (valid for a specific window) and emails it to the guest.

Rejection: If rejected, an email notification is sent to the guest explaining the outcome.
## Prerequisites

- PHP 8.2+ with required extensions (`openssl`, `pdo_mysql`, `mbstring`, `bcmath`, `curl`, `intl`, `zip`)
- Composer 2.x
- Node.js 18+ and npm
- MySQL 8 (or MariaDB 10.6+) for both the application database and the external AMS database
- Redis (optional) if you switch cache/queue/session drivers away from the database defaults

## Quick Start

```bash
git clone <repo-url>
cd InternetApplicationProgrammingProject
cp .env.example .env   # or rely on composer scripts to do this
composer install
npm install
php artisan key:generate
```

## Configure Environment Variables

Edit `.env` (copied from `.env.example`) and set the following keys:

- `DB_*` – primary application database credentials.
- `DB_UNIVERSITY_*` – connection details for the external University AMS database. A sample dump lives in `Dummy School AMS database/dummyAMS.sql`; import it into a separate schema and point these variables to it.
- `MAIL_*` or the dedicated `PHPMAILER_*` block if you plan on sending real emails (defaults log mail locally).
- Any optional services (Redis, AWS S3, etc.) according to your environment.

## Database Setup

```bash
# Create both databases manually, then run:
php artisan migrate
php artisan db:seed     # loads admins, guests, staff, and sample passes
```

If you prefer a one-liner, `composer run setup` covers install, key generation, migrations, npm install, and a production asset build (supply a `.env` beforehand).

## Running the App

- **Laravel HTTP server:** `php artisan serve`
- **Vite dev server:** `npm run dev`
- **Queue / scheduler (optional but recommended):**
  - `php artisan queue:listen`
  - `php artisan schedule:work`
- **All-in-one dev experience:** `composer run dev` leverages `npx concurrently` to boot Laravel, queue listener, log stream, and Vite with a single command.

Build production assets via `npm run build`. For a clean slate, clear caches with `php artisan optimize:clear`.

## Testing & QA

- Run the Laravel test suite: `composer test` (calls `php artisan test` after clearing cached config).
- Static analysis / formatting: `./vendor/bin/pint`
- Database seeding is idempotent; feel free to re-run `php artisan migrate:fresh --seed` during development.

## Troubleshooting

- **Missing APP_KEY:** rerun `php artisan key:generate`.
- **403/419 errors:** ensure `SESSION_DRIVER=database` tables exist (`php artisan session:table && php artisan migrate`).
- **External AMS connection issues:** verify the secondary DB credentials and that the dump from `Dummy School AMS database/dummyAMS.sql` was imported.
