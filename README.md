# Requestify

Requestify is an internal tool where employees send HR requests and managers approve or reject them. The collaborator gets an email with each decision.

Employees (collaborators) can request:

- **Documents**: payroll statements and work certificates, with attachments
- **Equipment** (material)
- **Leave** (paid or unpaid), with an optional attachment
- **Remote work**: for a period, or permanently
- **Evaluations**: an appraisal meeting on a chosen day and time

The dashboard shows a collaborator's pending requests and the decisions from the last 7 days. A history page lists all of their requests.

Admins review and approve or reject requests, and manage users. The **super admin** account is created from the command line and can't be edited or deleted from the app.

Built with Laravel 12, Blade, Tailwind CSS, Alpine.js and Vite.

## Run it locally

Requirements: PHP 8.2+ (with `pdo_sqlite`, `fileinfo`, `mbstring`, `openssl`), Composer and Node.js 20+.

```bash
composer install
npm install
npm run build

cp .env.example .env
php artisan key:generate
touch database/database.sqlite        # Windows: type nul > database\database.sqlite
php artisan migrate --seed
php artisan storage:link

php artisan serve                     # http://127.0.0.1:8000
```

`--seed` creates three local demo accounts, one per role. Their emails are in `database/seeders/DatabaseSeeder.php` and the password is `password`. With `MAIL_MAILER=log`, status emails are written to `storage/logs/laravel.log` instead of being sent.

To create a real super admin, for example in production, run:

```bash
php artisan app:create-user
```

### MySQL / Docker

Set `DB_CONNECTION=mysql` and the `DB_*` values in `.env`, or run the included Sail setup with `./vendor/bin/sail up`. It provides MySQL, phpMyAdmin on port 8888 and Mailpit on port 8025.

## Tests

```bash
php artisan test
```

The tests run on in-memory SQLite and don't send real emails. They cover:

- authentication and the profile page
- every request type
- approve/reject and the notification email
- role permissions in user management
- the dashboard's 7-day window
