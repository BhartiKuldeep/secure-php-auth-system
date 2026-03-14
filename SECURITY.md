# Security Policy

## Supported Versions
The latest version on `main` receives security updates.

## Reporting a Vulnerability
Please do not open a public issue for security vulnerabilities.

Instead:
1. Email the maintainer privately.
2. Include reproduction steps and impact details.
3. Share logs or screenshots only if they do not expose secrets.

## Security Features in This Project
- Password hashing with `password_hash()` and `password_verify()`.
- CSRF protection on state-changing requests.
- Session regeneration on login.
- Email verification before dashboard access.
- Password reset tokens with expiry.
- Login rate limiting.
- Security headers.
- Audit log for sensitive auth actions.

## Deployment Advice
- Serve the app over HTTPS.
- Rotate admin passwords immediately.
- Keep `.env` out of version control.
- Review log retention and mail log access.
