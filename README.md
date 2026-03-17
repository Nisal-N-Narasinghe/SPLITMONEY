# SplitMoney

A web application for splitting expenses among groups of people. Built with Laravel 12 and PHP 8.2.

## Features

- **User Authentication** — Register, log in, and log out securely
- **Groups** — Create groups, add members, and manage shared expenses
- **Expenses** — Add expenses and automatically split them among group members
- **Settlements** — Record payments to settle debts between members
- **Dashboard** — View balances and outstanding amounts at a glance
- **Admin Panel** — Admins can manage all users and groups from a dedicated `/admin` panel

## Tech Stack

| Layer    | Technology                    |
| -------- | ----------------------------- |
| Backend  | PHP 8.2, Laravel 12           |
| Database | SQLite (default) / PostgreSQL |
| Frontend | Blade templates, Bootstrap 5  |
| Assets   | Vite with Tailwind CSS        |

## Project Structure

```
app/
  Http/
    Controllers/       # AuthController, DashboardController, GroupController,
                       # ExpenseController, SettlementController, AdminController
    Middleware/        # AdminMiddleware — protects /admin routes
  Models/              # User, Group, GroupMember, Expense, ExpenseSplit, Settlement
  Services/
    BalanceService.php # Business logic for computing balances between members
database/
  migrations/          # Database schema
  seeders/             # UserSeeder — sample users + admin account
resources/views/       # Blade templates organised by feature (auth, groups, expenses, settlements, admin)
routes/
  web.php              # All application routes
```

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/Nisal-N-Narasinghe/SPLITMONEY.git
cd SPLITMONEY

# 2. Install dependencies
composer install
npm install

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Set up the database
touch database/database.sqlite   # for SQLite
php artisan migrate

# 5. (Optional) Seed sample data
php artisan db:seed

# 6. Build frontend assets
npm run build

# 7. Start the server
php artisan serve
```

The app will be available at `http://localhost:8000`.

## Admin Account

Admin accounts use the same login form at `/login`. To create an admin account, run:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name'     => 'Admin',
    'email'    => 'admin@example.com',
    'password' => bcrypt('yourpassword'),
    'is_admin' => true,
]);
```

Once logged in, the admin panel is accessible at `/admin`.

## Routes Overview

| Method | URI                           | Description         | Access |
| ------ | ----------------------------- | ------------------- | ------ |
| GET    | `/login`                      | Login page          | Guest  |
| GET    | `/register`                   | Register page       | Guest  |
| GET    | `/`                           | Dashboard           | Auth   |
| GET    | `/groups/create`              | Create a group      | Auth   |
| GET    | `/groups/{group}`             | View group details  | Auth   |
| GET    | `/expenses/create/{group}`    | Add an expense      | Auth   |
| GET    | `/settlements/create/{group}` | Record a settlement | Auth   |
| GET    | `/admin`                      | Admin dashboard     | Admin  |
| GET    | `/admin/users`                | Manage users        | Admin  |
| GET    | `/admin/groups`               | Manage groups       | Admin  |

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
