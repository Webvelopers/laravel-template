# Laravel 12 Starter Template

This repository is an opinionated **Laravel 12** starter template for new product development.

It is designed to give you a usable application foundation on day one instead of a bare framework install. The project already includes authentication flows, a starter UI, localization support, quality tooling, and development defaults that are practical for local work and easy to evolve for production.

## What This Template Includes

- Laravel 12 with PHP 8.2+
- Fortify-based authentication:
    - login
    - registration
    - password reset
    - email verification
    - two-factor authentication
- Livewire 3 with a reusable starter component
- Tailwind CSS 4 + Vite asset pipeline
- English and Spanish frontend translations
- Session-based locale switching from the profile page
- Pest test suite
- PHPStan, Pint, and Rector for code quality
- SQLite-first local setup for fast onboarding

## Starter Application Features

The template ships with a small but real application surface so you can start building immediately:

- `/` public landing page
- `/dashboard` authenticated and verified user dashboard
- `/profile` account settings page
- profile management
- password updates
- two-factor setup and recovery codes
- language switching between English and Spanish

## Project Structure

Important starting points in the codebase:

- `app/Actions/Fortify` custom Fortify actions for user registration, profile updates, and password handling
- `app/Http/Middleware/SetLocale.php` locale resolution from session
- `app/Livewire/StarterChecklist.php` example Livewire component used in the dashboard
- `app/Models/User.php` email verification and two-factor ready user model
- `app/Providers/FortifyServiceProvider.php` Fortify views, actions, and rate limits
- `config/fortify.php` Fortify feature toggles and auth-related defaults
- `lang/en` English translations
- `lang/es` Spanish translations
- `resources/views/welcome.blade.php` landing page
- `resources/views/dashboard.blade.php` starter dashboard
- `resources/views/profile.blade.php` account settings page
- `resources/views/auth` custom auth screens

## Requirements

Before starting, make sure your machine has:

- PHP 8.2 or newer
- Composer
- Node.js and npm
- SQLite available in your PHP environment

## Quick Start

Clone the repository and install everything needed to run the project locally.

```bash
cp .env.example .env
composer install
npm install
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
```

Then start the application:

```bash
composer run dev
```

This command starts the Laravel development server, queue worker, log watcher, and Vite dev server concurrently.

## Default Seeded User

The template creates a starter user through `database/seeders/DatabaseSeeder.php`.

- email: `starter@example.com`
- password: `password`

Use this account to validate the authentication flow after setup.

## Frontend Localization

The frontend is prepared for multilingual usage.

- English translations live in `lang/en/frontend.php`
- Spanish translations live in `lang/es/frontend.php`
- Validation, auth, password reset, and pagination messages are also translated in `lang/es`
- The active locale is stored in session
- Users can change the language from the account settings page

If you want to add another language, copy the translation files from `lang/en` and create a new locale directory.

## Authentication Notes

This template uses **Laravel Fortify** without Jetstream.

That means the authentication logic is already wired, but the UI remains fully customizable in your own Blade views.

Current behavior includes:

- verified users can access the dashboard and profile pages
- unverified users are redirected to the email verification flow
- users can enable and confirm two-factor authentication
- once 2FA is confirmed, recovery codes are shown and the QR block is hidden

## Development Commands

Useful project commands:

```bash
composer run dev
composer run test
composer run fix
composer run phpstan
composer run pest
npm run build
npm run lint
```

### What They Do

- `composer run dev` starts the local development stack
- `composer run test` runs refactoring checks, linting, static analysis, and tests
- `composer run fix` runs automated refactoring and formatting tasks
- `composer run phpstan` runs static analysis
- `composer run pest` runs the Pest test suite
- `npm run build` builds production assets
- `npm run lint` checks frontend formatting rules

## Quality Tooling

This template already includes a baseline quality workflow:

- **Pest** for feature and unit testing
- **PHPStan** for static analysis
- **Laravel Pint** for PHP formatting
- **Rector** for automated refactors and modernization
- **Prettier** for frontend formatting rules

This makes the repository suitable as a repeatable starter for teams that want guardrails from the beginning.

## Environment Notes

The `.env.example` file is already prepared with useful defaults.

Highlights:

- SQLite is the default database connection
- timezone is configurable through `APP_TIMEZONE`
- auth rate limits are configurable through environment variables
- password reset expiration and throttling are configurable through environment variables
- session cookie settings are relaxed for local development

## Recommended Customization After Cloning

After using this repository as a project base, update the following first:

1. Application name, URL, timezone, mail configuration, and locale defaults in `.env`
2. Landing page content in `resources/views/welcome.blade.php`
3. Dashboard content in `resources/views/dashboard.blade.php`
4. Profile and account settings experience in `resources/views/profile.blade.php`
5. Seeders and factories to match your domain
6. Translation files for your product language requirements
7. Brand styling, assets, and copywriting

## Testing and Verification

Before using the template for a real project, verify the baseline locally:

```bash
php artisan test
./vendor/bin/phpstan analyse --memory-limit=256M
./vendor/bin/pint --test
npm run build
```

These checks should pass before you begin feature work.

## Template Conventions

- `database/database.sqlite` is intended for local development and should not be committed
- lockfiles are intentionally tracked for reproducible installs
- the frontend favors Blade + Livewire for a simple starter architecture
- auth views are owned by the application, not hidden behind external scaffolding

## Suggested Next Steps

Once you create a new project from this template, a good first sequence is:

1. Rename the app and update the environment configuration
2. Replace the starter landing page with your product messaging
3. Model your first domain entities and migrations
4. Update seeders for your own roles, users, and fixtures
5. Add CI workflows for tests, static analysis, and formatting

## License

This project follows the Laravel ecosystem defaults unless you define a different license for your own derived project.
