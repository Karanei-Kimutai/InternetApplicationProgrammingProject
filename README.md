# Temporary Pass Application System
## Introduction
The current temporary pass application process in Strathmore is anything but smooth. Having to physically apply for a temporary pass comes with its own set of challenges that people have to go through to get access to the university.

Firstly, having a single physical temporary pass application point forces one to traverse their way to the right phase of the school to get a temporary pass and in situations where you have to make it to class or exams on time, that isn’t necessarily ideal.

In addition, the temporary pass application process relies heavily on the physical presence of staff and availability of course administrators. Sometimes, due to them having their own engagements, they may not be able to assist you leaving you stranded, unable to work your way around it. In addition, the process involves filling in physical forms, further increasing the time it takes to get the temporary pass. 

Another issue that arises from the physical forms is the inability to easily get summary data that could be used in making guidelines and policies and inform security decisions such as whether an individual is viable to get the temporary pass in the first place. Physical forms also take up physical space to store as well.

Yet another issue that is not accounted for in the current application process is situations where both students and guests want to apply for a temporary pass at the same time, this leads to long queues with guests holding up students from getting to class and or exam venues, making it even more frustrating for students.

After researching and getting to understand the problem from the perspective of the users, we gathered a list of user needs that could be met in a better way and could be incorporated with what works well at the moment:
1. Users want the time it takes to apply for a temporary pass to be shorter
2. Users want temporary pass application forms to be clearer, less confusing, and less redundant
3. Users want to a consistently available, known method of applying for a temporary pass
4. Users want a friendly application procedure mimicking staff treatment
5. Users want a simple and easy to understand application procedure
6. Users want faster approval for applications
7. Users want the temporary pass application process to be linked with their credentials thus making it easier to validate their identity

In the event of a software based solution or improvement, users want their data to be secure, they want the solution to be easy to use, have minimal glitches and they want to ensure the system doesn’t affect security in the university.

In light of this, we present a solution that aims to meet the needs of the users and make the temporary pass application process more streamlined, modern, and less dreadful.


## Project Overview

This project is an application designed to streamline the management of temporary campus passes, guest records, and security staff workflows. The system provides a digital solution for issuing and verifying temporary access passes, replacing manual logbooks with a more secure and efficient process.

Key Features:

1. Secure login for students and staff using their existing university credentials (simulated via an external AMS database).

2. A public-facing portal for visitors to request temporary passes.

3. A centralized hub for administrators to review, approve, or reject pass applications.

4. Security Portal: A dedicated interface for security guards to verify QR codes and check pass validity in real-time.

5. QR Code Integration: Automatic generation of secure QR codes for approved passes.

6. Email Notifications: Automated emails for application receipts, approvals, and rejections.

7. Conditional Approval: Smart logic that instantly approves standard requests while flagging restricted cases (e.g., frequent lost IDs) for manual review.

## Pass Approval Workflows

The system implements distinct workflows for different user types to balance security and convenience:

### 1.University Members (Automated)

Submission: Members log in via AMS credentials and submit a request (e.g., for a lost ID card).

Validation: The system performs an automatic check for abuse (e.g., preventing a member from requesting a "Lost ID" pass more than once within 30 days).

Outcome:

Success: If the request meets criteria, the pass is automatically approved instantly. A QR code is generated and emailed to the member immediately.

Rate Limited: If the member has exceeded the request limit for specific reasons, the system auto-rejects the request and instructs them to visit the security office physically for manual processing.

### 2.Guests (Manual)

Submission: Visitors apply via the public portal, providing their details, reason for visit, and a profile photo.

Queue: The request enters a Pending state and is queued on the Admin Dashboard.

Review: An administrator reviews the application details and reason.

Outcome:

Approval: When an admin clicks approve, the system generates a QR code (valid for a specific window) and emails it to the guest.

Rejection: If rejected, an email notification is sent to the guest explaining the outcome.

## Workflow Access Guide

Follow these routes to access the specific workflows for each user role:

University Members: To log in using your student/staff credentials and apply for a pass, go to ```/universityMemberLogin.```

Guests: To submit a visitor pass application form, go to ```/visit```.

Administrators: To access the admin dashboard for reviewing requests, go to ```/adminLogin```.

Security Guards: To log in to the QR verification portal, go to ```/security/login```.

Public: To see the system landing page, simply go to ```/```.
## Prerequisites

- PHP 8.2+
- Composer 2.x
- MySQL 8
- Apache/Preferred web server

## Quick Start

```bash
git clone https://github.com/Karanei-Kimutai/InternetApplicationProgrammingProject.git
cd InternetApplicationProgrammingProject
cp .env.example .env   # or rely on composer scripts to do this
composer install
php artisan key:generate
```

## Configure Environment Variables

Edit `.env` (copied from `.env.example`) and set the following keys:

- `DB_*` – primary application database credentials.
- `DB_UNIVERSITY_*` – connection details for the external University AMS database. Set `DB_UNIVERSITY_DATABASE=university_external_db` (or your chosen schema name). You do NOT need to import the SQL dump manually; instead, use the provided migrations and seeders (see below). The sample dump in `Dummy School AMS database/dummyAMS.sql` is for reference only.
- `MAIL_*` or the dedicated `PHPMAILER_*` block if you plan on sending real emails (defaults log mail locally).


## Database Setup


### Main Application Database
```bash
# Create the main application database manually, then run:
php artisan migrate
php artisan db:seed
```

### External University Database
```bash
# Only the students, lecturers, and v_university_members view should exist in the external database.
# Use the dedicated migrations and seeders:
php artisan migrate:fresh --database=university --path=database/university_migrations
php artisan db:seed --class=StudentsTableSeeder --database=university
php artisan db:seed --class=LecturersTableSeeder --database=university
```
This ensures only the required tables and view are present in `university_external_db`.

If you prefer a one-liner, `composer run setup` covers install, key generation, migrations, npm install, and a production asset build (supply a `.env` beforehand). Note: This will run all migrations on the default connection; for the external database, always use the commands above.

## Running the App

- **Laravel HTTP server:** `php artisan serve`

Build production assets via `npm run build`. For a clean slate, clear caches with `php artisan optimize:clear`.


## Troubleshooting

- **Missing APP_KEY:** rerun `php artisan key:generate`.
- **403/419 errors:** ensure `SESSION_DRIVER=database` tables exist (`php artisan session:table && php artisan migrate`).
- **External AMS connection issues:** verify the secondary DB credentials and that the correct migrations and seeders have been run for the external database (see above). You do not need to import the SQL dump manually.
