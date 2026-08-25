# Regen Med Health Diagnostic Platform

## Medical Imaging ## Medical Imaging & Regenerative Medicine Diagnostic Presentation System Regenerative Medicine Diagnostic Presentation System - Regen Med Health

A comprehensive, secure PHP-based local web application for medical imaging diagnostics and regenerative medicine treatment planning.

### Features

- **Diagnostic Dashboard** - Overview of all conditions, imaging protocols, and treatment pathways
- **Condition Profiles** - Complete diagnostic criteria for 5 medical conditions
- **Imaging Protocols** - Standardized acquisition protocols for MRI, CT, OCT, Ultrasound
- **Integrated Treatment Protocols** - Stem cell + PEMF + Supplement combinations
- **Supplement & Herbal Database** - Evidence-based supplements in tablet and herbal forms
- **PEMF Therapy Parameters** - Condition-specific electromagnetic therapy settings
- **Stem Cell Protocols** - Cell sources, delivery methods, and counts
- **GPU Cloud Provider Comparison** - Free and paid VPS for AI training
- **Data Management** - Upload scans, training data, and inference results
- **AI Recommendation Engine** - Generate personalized treatment recommendations
- **User Authentication** - Secure login/registration with session management
- **Full Database Storage** - SQLite backend for all sessions, browsing history, user data
- **Security Hardened** - CSRF, XSS, SQL injection, rate limiting, file upload protection

### Conditions Covered

1. Knee Osteoarthritis (MRI)
2. Age-Related Macular Degeneration (OCT)
3. Male Enhancing Fertility (Scrotal Ultrasound)
4. Female Enhancing Fertility (Transvaginal Ultrasound)
5. Prostate Disease (mpMRI)

### Security Features

- Content Security Policy (CSP) headers
- CSRF token validation
- SQL injection prevention (PDO prepared statements)
- XSS prevention (output encoding)
- Rate limiting (60 requests/minute)
- Secure session management
- Argon2id password hashing
- File upload validation (MIME type, extension, content scan)
- Honeypot anti-bot protection
- HTTP security headers (HSTS, X-Frame-Options, etc.)
- Directory access restrictions
- Input sanitization (GET, POST, COOKIE)

### Requirements

- PHP 8.1+
- PDO SQLite extension
- Apache/Nginx web server
- 50MB upload space minimum

### Installation

1. Copy files to web server document root
2. Ensure `data/`, `storage/`, and `uploads/` directories are writable
3. Navigate to the application URL
4. The database will be created automatically on first access

### Default Login

- Username: admin
- Password: admin123

### Usage

1. **Dashboard** - View overview and navigate to any module
2. **Conditions** - Select a condition to view diagnostic protocols
3. **Imaging** - Review standardized imaging acquisition protocols
4. **Protocols** - View integrated 4-phase treatment protocols
5. **Supplements** - Browse evidence-based supplement database
6. **PEMF** - View condition-specific electromagnetic therapy parameters
7. **Stem Cells** - Review stem cell sources and delivery methods
8. **Data Manager** - Upload scans, training data, and generate recommendations
9. **VPS Providers** - Compare GPU cloud providers for AI training

### License

For research and educational purposes only. Not a substitute for professional medical advice.
