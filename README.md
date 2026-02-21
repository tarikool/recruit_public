# QuickRecruit CRM - Project Information

## Overview
**QuickRecruit CRM** is a comprehensive Recruitment Agency CRM and Talent Acquisition System built with Laravel 10. The system helps recruitment agencies find and manage talent efficiently.

## Technical Stack

### Backend
- **Framework**: Laravel 10.16.1
- **PHP Version**: ^8.1
- **Database**: MySQL (implied by Laravel setup)

### Frontend
- **Build Tool**: Vite 3.0.2 with Laravel Vite Plugin
- **UI Framework**: Bootstrap 4.4.1
- **JavaScript**: Vue 2.7.0
- **CSS Preprocessor**: Sass 1.26.3

## Key Features & Integrations

### Core CRM Features
- **Candidate Management**: Profiles, education, experience, status tracking
- **Client Management**: Company and contact management
- **Job Management**: Job postings, assignments, opening status tracking
- **Communication**: Calls, meetings, notes, tasks
- **Billing System**: Integrated payment processing

### Authentication & Security
- Laravel Passport (OAuth2)
- Laravel Sanctum (API authentication)
- Google reCAPTCHA
- Role-based permissions (jeremykenedy/laravel-roles)

### Payment & Notifications
- **Payment Gateways**: PayPal, Stripe integration
- **Email Services**: Mailgun, Postmark, Vonage notifications
- **Real-time**: Pusher for live updates

### Additional Features
- PDF generation (laravel-dompdf)
- Image processing (intervention/image)
- Data tables (yajra/laravel-datatables)
- Multi-language support (laravel-translation-manager)
- Error tracking (Sentry)
- Toast notifications (yoeunes/toastr)

