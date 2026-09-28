<<<<<<< HEAD
# S.C.H.O.L.A.R. PHP foundation

Plain PHP pages for local XAMPP development, without styling or database access.

## Run

Start Apache in XAMPP and open http://localhost/SCHOLAR/. This redirects to `login.php`. Use **Preview dashboard** to open the empty lookup page. MySQL is not required.

## Files and behavior

- `login.php`: email/password form, server-side validation, CSRF protection and session initialization. Valid submissions show that authentication is unavailable; no submission signs in. Passwords are not stored or repopulated.
- `dashboard.php`: public development preview with search, year, department, program and workflow status filters above an empty table. GET submissions preserve filters; Clear filters resets them. Year validation works; record filtering awaits database integration.
- `includes/helpers.php`: HTML escaping, text input handling, sessions and CSRF helpers.
- `includes/auth.php`: login validation and an intentionally blank authentication lookup returning `null`.
- `includes/theses.php`: intentionally blank thesis lookup returning `[]`.

The earlier `config/database.php` and `includes/database.php` remain unused. Neither page includes them or opens a database connection.

## Future development

1. Fill in the authentication TODO with a prepared user lookup, account/role eligibility checks, and `password_verify()`. Update the login handler to process the returned user, regenerate the session ID and redirect only after successful authentication. Add login throttling, session timeout and logout when enabling authentication.
2. Add authentication and authorization to the dashboard before showing real records, and remove the public preview link.
3. Fill in the thesis query TODO with prepared filters, permission checks and soft-delete exclusions. Return title, authors, publication_year, department, program and workflow_status fields. Add confirmed filter options and pagination.

Database setup and SQL imports are separate future work. No records, accounts, or workflow statuses are created by these pages.
=======
# SCHOLAR
>>>>>>> 7b77166355d0c528d1a75b723d3f80659d74eeaa
