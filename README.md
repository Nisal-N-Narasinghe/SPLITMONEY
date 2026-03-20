# SplitMoney

A comprehensive web and API application for splitting expenses among groups of people. Built with Laravel 12 and PHP 8.2.

## Overview

SplitMoney is a full-featured expense splitting application that helps groups of people track shared expenses and manage settlements. It provides both a web interface for browser-based users and a RESTful API for mobile/external applications.

## Features

- **User Authentication** — Secure registration and login with token-based API authentication (Laravel Sanctum)
- **Group Management** — Create and manage expense-sharing groups with multiple members
- **Expense Tracking** — Add expenses and automatically split them equally among group members
- **Settlements** — Record and track payments to settle debts between members
- **Balance Calculation** — Real-time balance computation showing what each member owes or is owed
- **Dashboard** — View balances and outstanding amounts at a glance
- **Admin Panel** — Comprehensive admin interface to manage all users and groups
- **AI Trip Planner** — Generate day-by-day trip plans and budget breakdowns with Gemini, then create groups from approved plans

## Tech Stack

| Layer    | Technology                    |
| -------- | ----------------------------- |
| Backend  | PHP 8.2, Laravel 12           |
| Database | SQLite (default) / PostgreSQL |
| Frontend | Blade templates, Bootstrap 5  |
| Assets   | Vite 7 with Tailwind CSS 4    |
| Auth     | Laravel Sanctum (Token-based) |

## Project Structure

```
app/
  Http/
    Controllers/
      Api/               # API Controllers: AuthController, GroupController,
                         # ExpenseController, SettlementController, AdminController
            TripPlannerController.php  # Web controller for AI trip planning + create-group flow
    Middleware/          # AdminMiddleware — protects admin routes
    Models/                # User, Group, GroupMember, Expense, ExpenseSplit, Settlement, Trip
  Services/
    BalanceService.php   # Business logic for computing balances between members
        TripPlannerAiService.php  # Gemini integration and trip plan normalization
database/
  migrations/            # Database schema definitions
  seeders/               # DatabaseSeeder, UserSeeder
  factories/             # UserFactory for testing
resources/
  views/                 # Blade templates organized by feature
  js/                    # Frontend JavaScript
  css/                   # Stylesheet files
routes/
  api.php                # All API routes (prefixed with /api)
  web.php                # Web routes
  console.php            # Artisan commands
tests/                   # Unit and feature tests
```

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer 2+
- Node.js 18+ & npm
- PostgreSQL (optional, SQLite included by default)

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/Nisal-N-Narasinghe/SPLITMONEY.git
cd SPLITMONEY

# 2. Install dependencies
composer install
npm install

# 3. Set up environment variables
cp .env.example .env
php artisan key:generate

# Gemini (required for AI Trip Planner)
# GEMINI_API_KEY=your_api_key_here
# GEMINI_MODEL=gemini-2.5-flash
# GEMINI_TIMEOUT=30

# 4. Set up the database
# For SQLite (default):
touch database/database.sqlite

# For PostgreSQL, update .env with:
# DB_CONNECTION=pgsql
# DB_HOST=localhost
# DB_PORT=5432
# DB_DATABASE=splitmoney
# DB_USERNAME=postgres
# DB_PASSWORD=yourpassword

# 5. Run migrations
php artisan migrate

# 6. (Optional) Seed sample data
php artisan db:seed

# 7. Build frontend assets
npm run build

# 8. Start the server
php artisan serve
```

The app will be available at `http://localhost:8000`.

## AI Trip Planner

The Trip Planner helps users generate:

- destination-aware daily itinerary
- category-based budget estimates (accommodation, food, transport, activities, misc)
- optional daily budget split
- one-click group creation from the generated plan

### Setup

Add these values in your `.env`:

```dotenv
GEMINI_API_KEY=your_gemini_key
GEMINI_MODEL=gemini-2.5-flash
GEMINI_TIMEOUT=30
```

Then clear config cache:

```bash
php artisan config:clear
```

### Web Flow

1. Login to the app.
2. Open `/trip-planner`.
3. Enter destination, days, travelers, budget mode, and optional notes.
4. Click **Generate Plan**.
5. Review itinerary and budget.
6. Select members using checkbox boxes.
7. Create group from the generated plan.

### Data Persistence

- Chat history is **not persisted** in v1.
- Confirmed plans are stored in the `trips` table and linked to created groups.

### Admin Account Setup

To create an admin account, use Laravel Tinker:

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name'     => 'Admin',
    'email'    => 'admin@example.com',
    'password' => bcrypt('your_secure_password'),
    'is_admin' => true,
]);
```

Once logged in, the admin panel is accessible at `/admin`.

---

## API Documentation

All API endpoints are prefixed with `/api` and use JSON for request/response bodies.

### Authentication

The API uses **Token-based authentication** via Laravel Sanctum. Include the token in the Authorization header:

```
Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

### 1. Authentication Endpoints

#### Register a New User

```
POST /api/auth/register
```

**Request Body:**

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response:** `201 Created`

```json
{
    "message": "Registration successful.",
    "token": "1|abc123...",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "is_admin": false
    }
}
```

#### Login

```
POST /api/auth/login
```

**Request Body:**

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response:** `200 OK`

```json
{
    "message": "Login successful.",
    "token": "1|abc123...",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "is_admin": false
    }
}
```

#### Get Current User

```
GET /api/auth/me
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "is_admin": false,
    "created_at": "2026-03-18T10:30:00Z"
}
```

#### Logout

```
POST /api/auth/logout
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
{
    "message": "Logged out successfully."
}
```

---

### 2. User Endpoints

#### Get All Users (for member selection)

```
GET /api/users
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
[
    {
        "id": 2,
        "name": "Jane Doe",
        "email": "jane@example.com"
    },
    {
        "id": 3,
        "name": "Bob Smith",
        "email": "bob@example.com"
    }
]
```

---

### 3. Group Endpoints

#### List All Groups (user is member or creator)

```
GET /api/groups
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
[
    {
        "id": 1,
        "name": "Weekend Trip",
        "created_by": 1,
        "creator_name": "John Doe",
        "member_count": 3,
        "created_at": "2026-03-18T10:30:00Z"
    },
    {
        "id": 2,
        "name": "Roommates",
        "created_by": 1,
        "creator_name": "John Doe",
        "member_count": 2,
        "created_at": "2026-03-17T15:45:00Z"
    }
]
```

#### Create a New Group

```
POST /api/groups
```

**Headers:** `Authorization: Bearer {token}`

**Request Body:**

```json
{
    "name": "Weekend Trip",
    "members": [2, 3]
}
```

**Note:** The creator is automatically added to the group.

**Response:** `201 Created`

```json
{
    "message": "Group created successfully.",
    "group": {
        "id": 1,
        "name": "Weekend Trip",
        "created_by": 1,
        "members": [
            { "id": 1, "name": "John Doe" },
            { "id": 2, "name": "Jane Doe" },
            { "id": 3, "name": "Bob Smith" }
        ],
        "created_at": "2026-03-18T10:30:00Z"
    }
}
```

#### Get Group Details

```
GET /api/groups/{group_id}
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
{
    "id": 1,
    "name": "Weekend Trip",
    "created_by": 1,
    "members": [
        { "id": 1, "name": "John Doe" },
        { "id": 2, "name": "Jane Doe" },
        { "id": 3, "name": "Bob Smith" }
    ],
    "expenses": [
        {
            "id": 10,
            "description": "Hotel",
            "amount": "300.00",
            "paid_by": 1,
            "payer_name": "John Doe",
            "expense_date": "2026-03-18",
            "splits": [
                { "user_id": 1, "user_name": "John Doe", "amount": "100.00" },
                { "user_id": 2, "user_name": "Jane Doe", "amount": "100.00" },
                { "user_id": 3, "user_name": "Bob Smith", "amount": "100.00" }
            ]
        }
    ],
    "balances": [
        { "user_id": 1, "name": "John Doe", "balance": "200.00" },
        { "user_id": 2, "name": "Jane Doe", "balance": "-100.00" },
        { "user_id": 3, "name": "Bob Smith", "balance": "-100.00" }
    ],
    "created_at": "2026-03-18T10:30:00Z"
}
```

#### Delete a Group

```
DELETE /api/groups/{group_id}
```

**Headers:** `Authorization: Bearer {token}`

**Authorization:** Only the group creator or admin can delete.

**Response:** `200 OK`

```json
{
    "message": "Group deleted successfully."
}
```

---

### 4. Expense Endpoints

#### List Expenses in a Group

```
GET /api/groups/{group_id}/expenses
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
[
    {
        "id": 10,
        "description": "Hotel",
        "amount": "300.00",
        "paid_by": 1,
        "payer_name": "John Doe",
        "expense_date": "2026-03-18",
        "splits": [
            { "user_id": 1, "user_name": "John Doe", "amount": "100.00" },
            { "user_id": 2, "user_name": "Jane Doe", "amount": "100.00" },
            { "user_id": 3, "user_name": "Bob Smith", "amount": "100.00" }
        ]
    },
    {
        "id": 11,
        "description": "Dinner",
        "amount": "120.00",
        "paid_by": 2,
        "payer_name": "Jane Doe",
        "expense_date": "2026-03-18",
        "splits": [
            { "user_id": 1, "user_name": "John Doe", "amount": "40.00" },
            { "user_id": 2, "user_name": "Jane Doe", "amount": "40.00" },
            { "user_id": 3, "user_name": "Bob Smith", "amount": "40.00" }
        ]
    }
]
```

#### Add an Expense

```
POST /api/expenses
```

**Headers:** `Authorization: Bearer {token}`

**Request Body:**

```json
{
    "group_id": 1,
    "paid_by": 1,
    "amount": "300.00",
    "description": "Hotel",
    "expense_date": "2026-03-18",
    "members": [1, 2, 3]
}
```

**Note:** The amount is equally split among all members.

**Response:** `201 Created`

```json
{
    "message": "Expense added successfully.",
    "expense": {
        "id": 10,
        "description": "Hotel",
        "amount": "300.00",
        "paid_by": 1,
        "payer_name": "John Doe",
        "expense_date": "2026-03-18",
        "splits": [
            { "user_id": 1, "user_name": "John Doe", "amount": "100.00" },
            { "user_id": 2, "user_name": "Jane Doe", "amount": "100.00" },
            { "user_id": 3, "user_name": "Bob Smith", "amount": "100.00" }
        ]
    }
}
```

---

### 5. Settlement Endpoints

#### List Settlements in a Group

```
GET /api/groups/{group_id}/settlements
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
[
    {
        "id": 1,
        "group_id": 1,
        "paid_from": 2,
        "from_name": "Jane Doe",
        "paid_to": 1,
        "to_name": "John Doe",
        "amount": "100.00",
        "note": "Payment for hotel",
        "settled_at": "2026-03-19"
    }
]
```

#### Record a Settlement

```
POST /api/settlements
```

**Headers:** `Authorization: Bearer {token}`

**Request Body:**

```json
{
    "group_id": 1,
    "paid_from": 2,
    "paid_to": 1,
    "amount": "100.00",
    "settled_at": "2026-03-19",
    "note": "Payment for hotel"
}
```

**Response:** `201 Created`

```json
{
    "message": "Settlement recorded successfully.",
    "settlement": {
        "id": 1,
        "group_id": 1,
        "paid_from": 2,
        "from_name": "Jane Doe",
        "paid_to": 1,
        "to_name": "John Doe",
        "amount": "100.00",
        "note": "Payment for hotel",
        "settled_at": "2026-03-19"
    }
}
```

---

### 6. Admin Endpoints

**Authorization:** Only users with `is_admin = true` can access these endpoints.

#### Admin Dashboard

```
GET /api/admin/dashboard
```

**Headers:** `Authorization: Bearer {admin_token}`

**Response:** `200 OK`

```json
{
    "total_users": 15,
    "total_groups": 5,
    "total_expenses": 42,
    "total_settlements": 18,
    "recent_users": [
        {
            "id": 15,
            "name": "New User",
            "email": "newuser@example.com",
            "created_at": "2026-03-18T10:30:00Z"
        }
    ]
}
```

#### Get All Users

```
GET /api/admin/users
```

**Headers:** `Authorization: Bearer {admin_token}`

**Response:** `200 OK`

```json
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "group_count": 2,
        "created_at": "2026-03-10T08:00:00Z"
    },
    {
        "id": 2,
        "name": "Jane Doe",
        "email": "jane@example.com",
        "group_count": 1,
        "created_at": "2026-03-12T14:20:00Z"
    }
]
```

#### Delete a User

```
DELETE /api/admin/users/{user_id}
```

**Headers:** `Authorization: Bearer {admin_token}`

**Response:** `200 OK`

```json
{
    "message": "User deleted successfully."
}
```

**Note:** Cascading delete removes all groups created by the user.

#### Get All Groups

```
GET /api/admin/groups
```

**Headers:** `Authorization: Bearer {admin_token}`

**Response:** `200 OK`

```json
[
    {
        "id": 1,
        "name": "Weekend Trip",
        "created_by": 1,
        "creator_name": "John Doe",
        "member_count": 3,
        "expense_count": 5,
        "created_at": "2026-03-18T10:30:00Z"
    }
]
```

#### Delete a Group

```
DELETE /api/admin/groups/{group_id}
```

**Headers:** `Authorization: Bearer {admin_token}`

**Response:** `200 OK`

```json
{
    "message": "Group deleted successfully."
}
```

---

### 7. Trip Planner Endpoints (Authenticated Web)

These routes are under web auth middleware and are used by the planner page.

#### Open Planner Page

```
GET /trip-planner
```

#### Generate Trip Plan (JSON response)

```
POST /trip-planner/plan
```

**Request Body (form fields):**

```json
{
    "destination": "Bali",
    "days": 4,
    "travelers": 3,
    "budget_mode": "both",
    "total_budget": 1500,
    "notes": "Prefer beaches and local food"
}
```

**Response:** `200 OK`

```json
{
    "message": "Plan generated successfully.",
    "plan": {
        "summary": "...",
        "destination": "Bali",
        "days": 4,
        "travelers": 3,
        "budget_mode": "both",
        "daily_plan": [{ "day": 1, "title": "Arrival", "activities": ["..."] }],
        "budget": {
            "total": 1500,
            "by_day": [375, 375, 375, 375],
            "categories": {
                "accommodation": 500,
                "food": 350,
                "transport": 250,
                "activities": 300,
                "misc": 100
            }
        },
        "tips": ["..."]
    }
}
```

#### Create Group from Generated Plan

```
POST /trip-planner/create-group
```

**Request Body (form fields):**

```json
{
    "group_name": "Bali Trip",
    "member_ids": [2, 3],
    "plan_json": "{...}"
}
```

**Behavior:**

- Creates a new group.
- Adds selected members + creator.
- Saves plan metadata into `trips` with a `group_id` reference.

---

## Database Schema

### Users Table

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Groups Table

```sql
CREATE TABLE groups (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    created_by BIGINT NOT NULL (refers to users.id),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### GroupMembers Table

```sql
CREATE TABLE group_members (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    group_id BIGINT NOT NULL (refers to groups.id),
    user_id BIGINT NOT NULL (refers to users.id),
    created_at TIMESTAMP
);
```

### Expenses Table

```sql
CREATE TABLE expenses (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    group_id BIGINT NOT NULL (refers to groups.id),
    paid_by BIGINT NOT NULL (refers to users.id),
    amount DECIMAL(10, 2) NOT NULL,
    description VARCHAR(255) NOT NULL,
    expense_date DATE NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### ExpenseSplits Table

```sql
CREATE TABLE expense_splits (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    expense_id BIGINT NOT NULL (refers to expenses.id),
    user_id BIGINT NOT NULL (refers to users.id),
    amount DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP
);
```

### Settlements Table

```sql
CREATE TABLE settlements (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    group_id BIGINT NOT NULL (refers to groups.id),
    paid_from BIGINT NOT NULL (refers to users.id),
    paid_to BIGINT NOT NULL (refers to users.id),
    amount DECIMAL(10, 2) NOT NULL,
    settled_at DATE NOT NULL,
    note VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## Running the Application

### Development Mode

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start Vite dev server
npm run dev

# Terminal 3 (optional): Run queue listener
php artisan queue:listen
```

### Production Mode

```bash
# Build assets
npm run build

# Start server
php artisan serve --host=0.0.0.0 --port=8000
```

### Testing

```bash
# Run all tests
npm run test

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test tests/Feature/ExampleTest.php
```

---

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
