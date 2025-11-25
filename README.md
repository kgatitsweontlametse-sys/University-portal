# University-portal
# Student Registration & Academic Management System

A minimal, secure web-based Student Registration and Academic Management System built with PHP, MySQL and a small React prototype.  
This project demonstrates server-side form handling (PHP + PDO), MySQL CRUD, client-side interactivity (vanilla JS), simple REST-like PHP API endpoints, deletion logging, and a demo React UI.

---

Table of contents
- About
- Features
- Repository structure
- Quick setup (local)
- Database (db.sql)
- Configuration (php/config.php)
- Running the PHP app (php -S / XAMPP / cPanel)
- Testing & debug guide
- API endpoints (optional)
- React prototype
- Security notes
- Troubleshooting
- Contributing

---

About
This app lets administrators register and manage student records and allows students to view their profile and printable reports. It is intended as an educational/full-stack demo showing:
- HTML forms (Material-inspired) and client-side validation
- PHP form handling and PDO prepared statements (SQL injection protection)
- MySQL CRUD: Create, Read, Update, Delete
- Logging of deletions to a file for basic audit/recovery
- Printable reports (HTML; optional PDF generation)
- Small React prototype to illustrate a SPA migration path

Features
- Admin:
  - Register student (Full name, Student ID, Email, DOB, Course, Enrollment Date)
  - Dashboard to list/search/sort students
  - View profile, Update, Delete (with confirmation)
  - Deletion logs (php/logs/deletions.log)
- Student:
  - View profile and printable reports (profile summary, registration slip)
- Developer:
  - Simple REST-like API endpoints (for integration with frontend)
  - React prototype in `react/` demonstrating a dashboard

---

Repository structure (key files)
- db.sql — SQL to create `university` DB and `students` table (with sample rows)
- config.php — DB connection and app constants (place in php/ root)
- includes/functions.php (or function.php) — reusable helpers (validation, DB wrappers, logging)
- register.php — registration form
- process_register.php — form processing (insert)
- dashboard.php — list of students
- profile.php — student profile view
- update.php — update form + processing
- delete.php — delete handler (logs deletions)
- reports/
  - profile_report.php — printable profile
  - confirmation_slip.php — printable slip
- api/ (optional)
  - students.php — GET/POST for list/create
  - student.php — GET/POST/DELETE for single student
- assets/
  - styles.css
  - scripts.js
- react/ — small React prototype (optional)
- test_debug.php — debug helper to diagnose blank pages and DB connection

---

Quick setup (local)
1. Requirements
   - PHP 7.4+ (with PDO and cURL enabled)
   - MySQL / MariaDB
   - Node.js + npm (optional, for React prototype)

2. Create database and table
   - Run the provided `db.sql` to create the `university` database and `students` table:
     - Via CLI: mysql -u root -p < db.sql
     - Or import via phpMyAdmin

3. Place files
   - Place the PHP files in a folder served by your web server (e.g., `php/` in project root). If using XAMPP, put them in `htdocs/<project>`.

4. Configure DB credentials
   - Edit `config.php` and set:
     - DB_HOST, DB_PORT (optional)
     - DB_NAME (`university` by default)
     - DB_USER, DB_PASS

5. Create logs folder (if not created automatically)
   - Ensure `php/logs/` exists and is writable by the webserver. The `config.php` tries to create it automatically.

6. Start local server (quick test)
   - From the `php/` folder run:
     ```
     php -S localhost:8000
     ```
   - Open:
     - http://localhost:8000/register.php
     - http://localhost:8000/dashboard.php

---

Database schema (db.sql)
Use the `db.sql` file included in this repo. Key table `students` fields:
- id (INT auto-increment)
- student_id (VARCHAR unique)
- full_name, email, dob, course, enrollment_date
- status (ENUM: Active, Pending, Inactive)
- created_at (TIMESTAMP)

---

Configuration (php/config.php)
- Define APP_ROOT and error logging location (php/logs/php_error.log)
- DB credentials:
  - DB_HOST
  - DB_PORT
  - DB_NAME
  - DB_USER
  - DB_PASS
- PDO is created as $pdo and should be available to included pages.

Important: For development the config file enables display_errors. Turn this off in production.

---

Running & debug
- If a page shows blank or 500:
  - Open `php/test_debug.php` in your browser — it will show whether `config.php` is included, whether `$pdo` was created, and the tail of `php/logs/php_error.log`.
  - Check `php/logs/php_error.log`.
  - Ensure files are in the web server document root (or use php -S inside the folder).
  - Make sure PHP is actually executed (not uploaded to GitHub Pages — GitHub Pages is static-only and cannot run PHP).

test_debug.php (quick)
- Use it to confirm:
  - PHP is running
  - `config.php` included
  - DB connectivity
  - `includes/functions.php` inclusion

---

API (optional) — example endpoints
If you enabled/added `php/api/` endpoints, these endpoints are available for AJAX/React:
- GET /api/students.php
  - Response: { ok: true, data: [ ...students ] }
- POST /api/students.php
  - Create a student (JSON body: studentId, fullName, email, dob, course, enrollmentDate)
- GET /api/student.php?student_id=...
  - Get single student
- POST /api/student.php?student_id=...
  - Update student (JSON body fields)
- DELETE /api/student.php?student_id=...
  - Delete student (logged)

Use browser DevTools (Network) to inspect requests when integrating the frontend.

---

React prototype (optional)
- Folder: `react/` contains a minimal Create React App style prototype.
- To run:
  ```
  cd react
  npm install
  npm start
  ```
- The prototype uses mocked data and demonstrates a functional-component approach with hooks (useState, useEffect). To integrate with the PHP API, update fetch URLs and mapping.

---

Reports / Printing
- Each profile and confirmation slip is provided as printable HTML (reports/profile_report.php, reports/confirmation_slip.php).
- For server-side PDF generation, integrate FPDF or dompdf and use the student data to emit binary PDF output.

---

Security notes
- All DB operations use prepared statements (PDO) to prevent SQL injection.
- Server-side validation is implemented; client-side validation is for UX only and must not be trusted.
- In production:
  - Disable display_errors
  - Use HTTPS
  - Implement authentication and role-based access control (admin vs student)
  - Harden permissions on logs and config files
  - Rotate credentials and secure backups

---

Troubleshooting
- Blank page / 500:
  - Enable display_errors in config.php temporarily or check php/logs/php_error.log
  - Run `php -S localhost:8000` from the php folder and access test_debug.php
- Database connection issues:
  - Verify DB credentials and network access
  - Ensure the `university` DB and `students` table exist
- Files not found:
  - Ensure correct placement relative to web server document root; verify require paths use `__DIR__` for consistency

---

Contributing
- Fixes, improvements and feature requests are welcome.
- Suggested improvements:
  - Add authentication + access control
  - Server-side PDF generation (FPDF / dompdf)
  - REST API with Node/Express and JWT authentication
  - React SPA fully wired to API
  - Add unit and integration tests

---

License & attribution
This repository is an educational example. Adapt and reuse as needed — include attribution if you redistribute significant portions.

--
