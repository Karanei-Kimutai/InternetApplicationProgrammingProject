Project Startup & Architecture Guide
-----------------------------------------
This document serves two purposes:

The Creation Log: A step-by-step history of how this project was built from an empty folder.

The Setup Manual: A human-friendly guide to understanding and starting the dual-database architecture.

===========================================================
Part 1: The Creation Story (Dev Log)
===========================================================
This project didn't just appear; it was built in 5 key stages. Here is the reconstruction of the development timeline:

Step 1: The Skeleton (Genesis)
We started by initializing a fresh Laravel framework to handle the heavy lifting (routing, security, MVC structure).

Command: composer create-project laravel/laravel InternetApplicationProgrammingProject

Result: A standard Laravel directory structure was created.

Step 2: The Toolbelt (Dependencies)
 We realized the app needed specific tools that Laravel doesn't provide out of the box.

Action: Added simplesoftwareio/simple-qrcode for generating pass codes and phpmailer/phpmailer for robust email delivery.

Config: We also modified config/database.php here to define the "University" connection.

Step 3: The Foundation (Database Schema)
Before writing code, we defined the data structure.

Models Created: Admin, Guest, TemporaryPass, SecurityStaff, UniversityMember.

Migrations: We wrote the blueprints to create tables like temporary_passes (with QR code paths) and email_logs.

Step 4: The Logic (Controllers & Routes)

Admin Portal: AdminController for management.

Security Portal: SecurityAuthController for staff to log in and scan passes.

Member Portal: UniversityMemberLoginController that checks the legacy database.

Step 5: The Face (Frontend & Docker)

Views: Created the dashboard (adminDashboard.blade.php) and login pages.

Deployment: Added a Dockerfile to build the app with Nginx and PHP-FPM in one go.

-----------------------------------------------------------
===========================================================
Part 2: The "Two-Brain" Architecture
===========================================================
To simulate a real university environment, this system requires two separate databases. It is crucial you understand this before running the setup commands.

The New Brain (temporary_pass_db)

What is it? The database belonging to this specific application.

What's inside? Temporary passes, guest details, system admins, and security staff logs.

Who controls it? You do, via Laravel Migrations.

The Old Brain (university_external_db)

What is it? A simulation of the University's existing Admission System (Legacy AMS).

What's inside? Thousands of students and lecturers (v_university_members).

Who controls it? Nobody. We treat it as "Read-Only." We check this DB to see if a student exists, but we never save data to it.