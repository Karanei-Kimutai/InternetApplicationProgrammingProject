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

-----------------------------------------------------------
Part 3: Step-by-Step Setup Guide
Follow these steps exactly to wake up the application.

1. Create the Database Containers
Open your MySQL terminal (or Workbench) and run these two commands to create the empty shells:

SQL

CREATE DATABASE temporary_pass_db;
CREATE DATABASE university_external_db;
2. Feed the "Old Brain" (Import Legacy Data)
We need to populate the university database with the dummy students and lecturers provided in the project.

Bash

# Run from the project root
mysql -u root -p university_external_db < "Dummy School AMS database/dummyAMS.sql"
Note: This creates the students and lecturers tables and the view v_university_members used for login.

3. Configure the Environment
Duplicate the example file and open it for editing.

Bash

cp .env.example .env
Now, edit .env to connect to BOTH databases:

Ini, TOML

# 1. Main Application Connection
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=temporary_pass_db
DB_USERNAME=root
DB_PASSWORD=your_password

# 2. External University Connection
DB_UNIVERSITY_CONNECTION=university
DB_UNIVERSITY_HOST=127.0.0.1
DB_UNIVERSITY_DATABASE=university_external_db
DB_UNIVERSITY_USERNAME=root
DB_UNIVERSITY_PASSWORD=your_password
4. Feed the "New Brain" (Migrate & Seed)
Now we install the application tables and create the default Admin/Security users.

Bash

# Install dependencies
composer install
npm install

# Build tables and add default users
php artisan migrate
php artisan db:seed
The seeder will create an Admin user (check AdminSeeder.php for credentials) and Security Staff users.

5. Launch 🚀
You can start everything (Server, Queue, Vite) with one command:

Bash

composer run dev
This leverages the script defined in composer.json to run php artisan serve, queue:listen, and npm run dev concurrently.
