# Split Money App

A Laravel 12 expense splitting application.

## Project Overview

This is a web app for splitting expenses among groups. Users can:
- Create groups and add members
- Add expenses and split them among group members
- Record settlements to pay off debts
- View a dashboard showing balances

## Tech Stack

- **Backend**: PHP 8.2, Laravel 12
- **Database**: SQLite (local, file-based at `database/database.sqlite`)
- **Frontend**: Laravel Blade templates with Bootstrap 5
- **Asset Pipeline**: Vite 7 with Tailwind CSS 4

## Project Structure

- `app/Models/` - Eloquent models: User, Group, GroupMember, Expense, ExpenseSplit, Settlement
- `app/Http/Controllers/` - DashboardController, GroupController, ExpenseController, SettlementController
- `app/Services/BalanceService.php` - Business logic for computing balances
- `resources/views/` - Blade templates organized by feature
- `database/migrations/` - Database schema migrations
- `routes/web.php` - Application routes

## Running the App

The app runs on port 5000 via `php artisan serve --host=0.0.0.0 --port=5000`.

Vite assets are built with `npm run build` for production.

## Setup Commands

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install
npm run build
```

## Environment

- `.env` is gitignored; based on `.env.example`
- Default DB: SQLite at `database/database.sqlite`
- Session driver: database
