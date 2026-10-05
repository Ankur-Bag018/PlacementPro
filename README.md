# PlacementPro — Campus Placement Portal

A PHP + MySQL + Bootstrap 5 web app for managing campus placements, built from
the blueprint by Ankur Bag (BCA, Techno Main Salt Lake).

## Setup (XAMPP)

1. Install [XAMPP](https://www.apachefriends.org/) and start **Apache** and **MySQL**.
2. Copy this entire `placement_portal` folder into your XAMPP `htdocs` directory,
   so the path is: `htdocs/placement_portal/`.
3. Open **phpMyAdmin** (`http://localhost/phpmyadmin`), create a new database
   or just import `schema.sql` directly (it creates the database for you):
   - Click **Import** → choose `schema.sql` → **Go**.
4. If your MySQL root user has a password, or you use a different username,
   update `config/db.php`:
   ```php
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```
5. Visit `http://localhost/placement_portal/` in your browser.
   - New students: click **Register**.
   - To create an **admin** account: register normally, then in phpMyAdmin run:
     ```sql
     UPDATE users SET role = 'admin' WHERE email = 'youradmin@email.com';
     ```

## Folder Structure

```
placement_portal/
├── config/db.php              # PDO MySQL connection
├── includes/
│   ├── header.php             # Bootstrap navbar + layout open
│   ├── footer.php             # Layout close + scripts
│   └── auth_check.php         # Session + RBAC guard (include at top of protected pages)
├── admin/
│   ├── dashboard.php          # List jobs, delete jobs, applicant counts
│   ├── add_job.php            # Post a new placement drive
│   └── view_applicants.php    # View/download resumes, update application status
├── student/
│   ├── dashboard.php          # Job feed, eligibility check, apply button
│   ├── profile.php            # Edit CGPA/skills, upload resume (PDF only)
│   └── my_applications.php    # Track application status
├── uploads/resumes/           # Uploaded resumes (randomized filenames, .htaccess protected)
├── login.php / register.php / logout.php
├── index.php                  # Redirects based on session/role
└── schema.sql                 # Full database schema
```

## Security Features Implemented

- **Password hashing** — `password_hash()` / `password_verify()` (bcrypt).
- **SQL injection prevention** — all queries use PDO prepared statements
  (`PDO::ATTR_EMULATE_PREPARES => false` forces real server-side prepares).
- **Session hardening** — `session_regenerate_id()` on login, full session
  teardown on logout, RBAC enforced via `auth_check.php` on every protected page.
- **Secure file uploads** — resumes are validated by both file extension *and*
  MIME type (via `finfo`), capped at 5MB, renamed to a random unguessable
  filename on save (prevents overwrite attacks and path traversal), and the
  upload directory has directory-listing disabled via `.htaccess`.
- **Output escaping** — all dynamic output passed through `htmlspecialchars()`
  to prevent stored/reflected XSS.
- **Double-application prevention** — a unique key on `(job_id, student_id)`
  in the `applications` table, enforced at the database level.
- **Server-side re-validation** — CGPA eligibility and deadline are checked
  again on the server when a student applies, not just in the UI.

## Notes / Possible Next Steps

- Add CSRF tokens to forms for extra protection against cross-site request forgery.
- Add pagination if the number of job postings or applicants grows large.
- Add email notifications when an application status changes.
- Add a "forgot password" flow.
