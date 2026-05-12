<div align="center">

<img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
<img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" />
<img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
<img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" />
<img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=black" />

<br /><br />

```
███████╗██╗     ███████╗███████╗████████╗   ██╗ ██████╗
██╔════╝██║     ██╔════╝██╔════╝╚══██╔══╝   ██║██╔═══██╗
█████╗  ██║     █████╗  █████╗     ██║      ██║██║   ██║
██╔══╝  ██║     ██╔══╝  ██╔══╝     ██║      ██║██║   ██║
██║     ███████╗███████╗███████╗   ██║      ██║╚██████╔╝
╚═╝     ╚══════╝╚══════╝╚══════╝   ╚═╝      ╚═╝ ╚═════╝
```

# ⚡ FLEET.IO — Fleet Command & Control System

**A production-grade, full-stack Fleet Management Platform built with Laravel.**  
Real-time asset tracking · AI maintenance prediction · Blockchain-style financial ledger · Mobile driver portal

<br />

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
![Status](https://img.shields.io/badge/Status-Active-brightgreen)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)

</div>

---

## 📌 Table of Contents

- [Overview](#-overview)
- [Core Modules](#-core-modules)
- [Tech Stack](#-tech-stack)
- [System Architecture](#-system-architecture)
- [Database Schema](#-database-schema)
- [Authentication System](#-authentication-system)
- [Driver Mobile Portal](#-driver-mobile-portal)
- [Installation & Setup](#-installation--setup)
- [Environment Variables](#-environment-variables)
- [Routes Reference](#-routes-reference)
- [Key Business Logic](#-key-business-logic)
- [Folder Structure](#-folder-structure)
- [Developer Notes](#-developer-notes)

---

## 🧭 Overview

**FLEET.IO** is a complete, enterprise-style fleet operations platform designed to give logistics companies full command over their truck fleets. It covers everything from live vehicle tracking and driver management to AI-driven maintenance forecasting and a tamper-evident financial ledger.

The system ships with two distinct interfaces:

| Interface | Audience | Access |
|---|---|---|
| **Admin Command Center** | Dispatchers, Managers | Multi-factor login (Email + Password + CNIC + PIN) |
| **Driver Mobile Portal** | Truck Drivers | Employee ID — mobile-optimized UI |

The entire frontend is built with a dark military/ops aesthetic using Tailwind CSS, Alpine.js for interactivity, and the Orbitron + Poppins typefaces to give it a polished, premium feel.

---

## 🧩 Core Modules

### 1. 🖥️ Command Center (Dashboard)
The mission-control landing page for admins. Displays four live KPI cards — total vehicles, active vehicles (those currently moving), cumulative fuel consumed, and anomalous security alerts. Features an intelligence stream log and a satellite map panel.

**Live data pulled from:**
- `Truck::count()` → total fleet size  
- `Truck::where('current_speed', '>', 0)->count()` → units in transit  
- `FuelLog::sum('liters')` → total fuel burned  
- `FuelLog::where('security_status', 'Anomalous')->count()` → fraud alerts  

---

### 2. 🚛 Asset Radar (Truck Management)
Full CRUD interface for the truck fleet. Each truck card dynamically shows real-time status (IN TRANSIT vs IDLE) based on its `current_speed` field, with a live telemetry speed bar.

**Deploy New Asset:** Admins can register a new truck by entering only a unit number. The system auto-generates a cryptographic VIN (`VIN-` + 12-char MD5 hash of timestamp + random seed).

**Truck Card shows:**
- Unit number & vehicle type
- Live status badge (animated pulse for IN TRANSIT)
- Current velocity with a proportional progress bar
- Hover effects based on operational state

---

### 3. ⛽ Fuel Intelligence
A complete fuel tracking and fraud detection module. Every refuel event is logged with a SHA-256 blockchain-style hash receipt and automatically cross-posted to the Financial Ledger as an `EXPENSE` entry.

**AI Security Rule:** Any fuel log exceeding **500 liters** in a single transaction is automatically flagged as `Anomalous`. Normal logs are marked `Verified`.

**Each fuel log stores:**
- Linked truck (foreign key)
- Liters pumped + total cost
- GPS location / station name (auto-uppercased)
- `blockchain_hash` — `0x` + 16 chars from `sha256(time + rand())`
- `security_status` — `Verified` or `Anomalous`

**Auto-Ledger Deduction:** On every fuel log submission, a corresponding `EXPENSE` transaction is created in `ledger_transactions` automatically, keeping financials always in sync without any manual input.

---

### 4. 👨‍✈️ Driver Roster
Full driver management panel. Each driver card renders a dynamic avatar (via UI Avatars API using their real name), shows live fatigue level as a colored progress bar, safety score, and current status badge.

**Recruit New Driver:**
- Full name, Employee ID (auto-uppercased), License Class (Class-A, Class-B, Hazmat)
- New recruits start with: `fatigue_level = 0`, `safety_score = 100`, `status = RESTING`
- Employee ID must be globally unique

**Driver Status Colors:**
- `DRIVING` → Cyan/Emerald indicators
- `RESTING` / `OFF-DUTY` → Amber pulsing badge

---

### 5. 🔧 AI Maintenance Matrix
Predictive maintenance dashboard. Alerts are sorted by `days_to_failure` ascending so the most urgent repairs always appear first. A 3D holographic scanner animation runs in the background to reinforce the AI diagnostic theme.

**Each alert stores:**
- Linked truck
- Component name (e.g., Transmission, Brakes, Engine Oil)
- `wear_percentage` — rendered as a dynamic color-coded progress bar
- `days_to_failure` — AI prediction of when the component will fail
- `severity` — `URGENT` (red) or `WARNING` (amber)

**Empty State:** If no alerts exist, a full-screen "All Systems Nominal" shield graphic is displayed.

Drivers can also trigger an emergency `SOS` from the mobile portal, which creates a `SYSTEM EMERGENCY` maintenance alert with `wear_percentage = 100` for Command Center to see instantly.

---

### 6. 💰 Immutable Financial Ledger
A blockchain-inspired financial ledger tracking all revenue and expenses across the fleet. Every transaction gets a unique `tx_hash` (SHA-256 based) making the record tamper-evident.

**Live Financial Metrics computed on the fly:**
```
Gross Revenue  = SUM of all REVENUE transactions
Total Expenses = SUM of all EXPENSE transactions
Net Margin     = ((Revenue - Expenses) / Revenue) * 100
```

**Transaction types:** `REVENUE` (green) · `EXPENSE` (red)  
**Auto-entries created by:** Fuel logs, manual dispatching

---

### 7. 🛡️ Security Command
A visual security operations panel. Features a live Alpine.js terminal that cycles through randomized security log messages every 2.5 seconds — simulating a real-time event feed. Includes a CSS-animated cyber radar and rolling AES-256 encryption key counter.

**Displayed metrics:**
- Rolling encryption key count (randomized between 1000–1200)
- Blocked threats: static display of 42,091 last-24h events
- Network status: SECURE with animated ping indicator

---

### 8. ⚙️ System Configuration
Persistent global system settings stored in the `system_settings` table. Settings are auto-seeded with safe defaults on first access via `firstOrCreate`.

**Configurable parameters:**
| Parameter | Default | Description |
|---|---|---|
| `max_speed_limit` | 110 km/h | Fleet-wide speed cap |
| `idle_engine_cutoff` | 15 min | Auto-cutoff timer for idling engines |
| `google_maps_key` | — | Geolocation API key |
| `strict_cnic_validation` | `true` | Enforces format-exact CNIC for admin accounts |

The page wraps the entire layout in a single `<form>` tag — settings are saved in one click via the header SAVE CONFIG button.

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 12.x (PHP 8.2+) |
| **Database** | MySQL |
| **ORM** | Eloquent |
| **Frontend Styling** | Tailwind CSS (CDN) |
| **JS Interactivity** | Alpine.js 3.x |
| **Icons** | Font Awesome 6 |
| **Typography** | Google Fonts — Orbitron · Poppins · JetBrains Mono |
| **Auth** | Laravel `Auth::attempt()` with multi-factor credential matching |
| **Driver Auth** | Session-based (no password required — Employee ID only) |
| **Hashing** | `hash('sha256', ...)` — PHP native |
| **Map Embed** | OpenStreetMap (Driver Portal) |

---

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────┐
│                  FLEET.IO SYSTEM                 │
├──────────────────────┬──────────────────────────┤
│   ADMIN PANEL        │   DRIVER MOBILE PORTAL   │
│  (DashboardController│  (DriverPortalController) │
│                      │                           │
│  /command-center     │   /portal/login           │
│  /assets             │   /portal/mission         │
│  /fuel               │   /portal/mission/lock    │
│  /drivers            │   /portal/mission/fuel    │
│  /maintenance        │   /portal/mission/sos     │
│  /ledger             │                           │
│  /security           │   Session-based auth      │
│  /settings           │   Mobile-first UI         │
│                      │                           │
│  4-Factor Auth       │                           │
│  (SecurityController)│                           │
└──────────────────────┴──────────────────────────┘
             │                   │
             ▼                   ▼
┌─────────────────────────────────────────────────┐
│                  MySQL Database                  │
│  users · trucks · drivers · fuel_logs           │
│  maintenance_alerts · ledger_transactions        │
│  system_settings · sessions · cache             │
└─────────────────────────────────────────────────┘
```

---

## 🗄️ Database Schema

### `users`
| Column | Type | Notes |
|---|---|---|
| `id` | BIGINT PK | Auto increment |
| `name` | VARCHAR | Display name |
| `email` | VARCHAR UNIQUE | Login credential |
| `cnic` | VARCHAR UNIQUE NULLABLE | Auth factor #3 |
| `pin_code` | VARCHAR NULLABLE | Auth factor #4 |
| `role` | VARCHAR | Default: `dispatcher` |
| `password` | VARCHAR | Hashed (bcrypt) |
| `timestamps` | — | created_at, updated_at |

### `trucks`
| Column | Type | Notes |
|---|---|---|
| `unit_number` | VARCHAR UNIQUE | e.g. `TRK-990` |
| `vin` | VARCHAR UNIQUE | Auto-generated |
| `status` | VARCHAR | `En Route`, `Offline`, `Loading` |
| `current_speed` | INT | 0 = idle, >0 = in transit |
| `latitude` / `longitude` | DECIMAL(10,7) | GPS coordinates |
| `ai_health_score` | INT | 0–100, default 100 |

### `fuel_logs`
| Column | Type | Notes |
|---|---|---|
| `truck_id` | FK → trucks | Cascade delete |
| `liters` | DECIMAL(8,2) | Volume logged |
| `cost` | DECIMAL(10,2) | Transaction cost |
| `location` | VARCHAR | Station / GPS node |
| `blockchain_hash` | VARCHAR UNIQUE | SHA-256 receipt |
| `security_status` | VARCHAR | `Verified` or `Anomalous` |

### `drivers`
| Column | Type | Notes |
|---|---|---|
| `employee_id` | VARCHAR UNIQUE | e.g. `DRV-001` — used for portal login |
| `license_class` | VARCHAR | `Class-A`, `Class-B`, `Hazmat` |
| `fatigue_level` | INT | 0–100 |
| `safety_score` | INT | 0–100, default 100 |
| `status` | VARCHAR | `DRIVING`, `RESTING`, `OFF-DUTY` |

### `maintenance_alerts`
| Column | Type | Notes |
|---|---|---|
| `truck_id` | FK → trucks | Cascade delete |
| `component` | VARCHAR | e.g. `Transmission`, `Brakes` |
| `wear_percentage` | INT | 0–100 |
| `days_to_failure` | INT | AI-predicted failure window |
| `severity` | VARCHAR | `URGENT`, `WARNING`, `OPTIMAL` |

### `ledger_transactions`
| Column | Type | Notes |
|---|---|---|
| `tx_hash` | VARCHAR UNIQUE | Blockchain-style identifier |
| `truck_unit` | VARCHAR | e.g. `TRK-990` |
| `type` | VARCHAR | `REVENUE` or `EXPENSE` |
| `description` | VARCHAR | e.g. `FUEL AUTO-DEDUCT` |
| `amount` | DECIMAL(12,2) | Supports up to billions |

### `system_settings`
| Column | Type | Default |
|---|---|---|
| `max_speed_limit` | INT | 110 |
| `idle_engine_cutoff` | INT | 15 |
| `google_maps_key` | VARCHAR NULLABLE | — |
| `strict_cnic_validation` | BOOLEAN | true |

---

## 🔐 Authentication System

### Admin Auth — 4-Factor Security
FLEET.IO uses a custom 4-factor authentication system through `SecurityController`. All four fields must match simultaneously against the `users` table:

```
Email Address  →  users.email
Master Password → users.password (bcrypt)
CNIC Number    →  users.cnic
Security PIN   →  users.pin_code
```

Login route: `POST /gateway/auth`  
On success: Redirects to `/command-center`  
On failure: Returns validation error — "Access Denied. Invalid credentials or PIN."

### Driver Portal Auth — Session-Based
Drivers authenticate using only their `employee_id`. No password required. On success, the session stores:

```php
session([
    'driver_id'   => $driver->id,
    'driver_name' => $driver->name,
    'employee_id' => $driver->employee_id,
]);
```

All protected portal routes check `session()->has('driver_id')` and redirect to login if not present.

---

## 📱 Driver Mobile Portal

A fully separate, mobile-first interface for drivers. The UI is constrained to `max-w-md` with a phone-frame aesthetic (rounded corners, fake notch status bar) — it looks and feels like a native mobile app.

### Portal Flow:

```
/portal/login
    → Enter Employee ID (e.g. DRV-001)
    → Session created

/portal/mission
    ├── VEHICLE ASSIGNMENT — pick an idle truck & lock it
    │       → Sets truck.current_speed = 85 (marks as IN TRANSIT)
    ├── LOG FUEL — opens Alpine.js modal
    │       → Creates FuelLog record
    │       → Auto-deducts from Financial Ledger
    ├── SOS ALERT — one-tap emergency beacon
    │       → Creates MaintenanceAlert with severity CRITICAL
    │       → Immediately visible in admin maintenance panel
    └── GPS MAP — OpenStreetMap embed (dark mode inverted filter)
```

**Recent Fuel History** is shown inline on the mission page for the driver's currently locked truck (last 5 entries).

---

## 🚀 Installation & Setup

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js (for any optional frontend builds)

### Step 1: Clone the Repository
```bash
git clone https://github.com/yourusername/fleet-io.git
cd fleet-io
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Configure Database
Open `.env` and update your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fleet_io
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 5: Run Migrations
```bash
php artisan migrate
```

> ⚠️ **Important:** There are two `create_fuel_logs_table` migration files in the project history. The authoritative one is `2026_05_11_185737_create_fuel_logs_table.php`. The earlier `065045` version is superseded. If you run into a "table already exists" error, check your migration order and drop any stale tables.

### Step 6: Seed the Database
```bash
php artisan db:seed
```

Create your first admin user manually or via tinker:
```bash
php artisan tinker
```
```php
App\Models\User::create([
    'name'     => 'Commander Ifzal',
    'email'    => 'admin@fleet.io',
    'password' => bcrypt('yourpassword'),
    'cnic'     => '35202-1234567-8',
    'pin_code' => '9999',
    'role'     => 'admin',
]);
```

### Step 7: Launch
```bash
php artisan serve
```

Visit `http://127.0.0.1:8000/gateway` for the admin login.  
Visit `http://127.0.0.1:8000/portal/login` for the driver portal.

---

## 🔑 Environment Variables

| Variable | Description |
|---|---|
| `APP_NAME` | Application name (default: `Fleet.io`) |
| `APP_ENV` | `local` / `production` |
| `APP_KEY` | Auto-generated by `artisan key:generate` |
| `APP_URL` | Base URL of your deployment |
| `DB_*` | MySQL connection credentials |
| `SESSION_DRIVER` | `database` (sessions table is included in migrations) |
| `CACHE_DRIVER` | `database` (cache table is included in migrations) |

---

## 🗺️ Routes Reference

### Admin Routes

| Method | URI | Controller Method | Description |
|---|---|---|---|
| `GET` | `/gateway` | `SecurityController@showGateway` | Admin login page |
| `POST` | `/gateway/auth` | `SecurityController@authenticate` | Process 4-factor login |
| `GET` | `/command-center` | `DashboardController@showCommandCenter` | Main dashboard |
| `GET` | `/dashboard/assets` | `DashboardController@showAssets` | Asset radar |
| `POST` | `/dashboard/assets/deploy` | `DashboardController@storeAsset` | Register new truck |
| `GET` | `/dashboard/fuel` | `DashboardController@showFuel` | Fuel intelligence |
| `POST` | `/dashboard/fuel/log` | `DashboardController@storeFuel` | Log + auto-deduct fuel |
| `GET` | `/dashboard/drivers` | `DashboardController@showDrivers` | Driver roster |
| `POST` | `/dashboard/drivers/recruit` | `DashboardController@storeDriver` | Recruit new driver |
| `GET` | `/dashboard/maintenance` | `DashboardController@showMaintenance` | AI maintenance matrix |
| `GET` | `/dashboard/ledger` | `DashboardController@showLedger` | Financial ledger |
| `GET` | `/dashboard/security` | `DashboardController@showSecurity` | Security command |
| `GET` | `/dashboard/settings` | `DashboardController@showSettings` | System config |
| `POST` | `/dashboard/settings/update` | `DashboardController@updateSettings` | Save config changes |

### Driver Portal Routes

| Method | URI | Controller Method | Description |
|---|---|---|---|
| `GET` | `/portal/login` | `DriverPortalController@showLogin` | Driver login screen |
| `POST` | `/portal/authenticate` | `DriverPortalController@authenticate` | Verify Employee ID |
| `GET` | `/portal/mission` | `DriverPortalController@showMission` | Mission dashboard |
| `POST` | `/portal/mission/lock` | `DriverPortalController@lockAsset` | Lock a truck |
| `POST` | `/portal/mission/fuel` | `DriverPortalController@logFuel` | Log fuel + auto-ledger |
| `POST` | `/portal/mission/sos` | `DriverPortalController@triggerSOS` | Fire SOS beacon |

---

## 💡 Key Business Logic

### 1. Fuel Fraud Detection
```php
// Any single refuel over 500L is automatically flagged
$status = $request->liters > 500 ? 'Anomalous' : 'Verified';
```

### 2. Blockchain Hash Generation
```php
// Applied to every fuel log and ledger transaction
'blockchain_hash' => '0x' . substr(hash('sha256', time() . rand()), 0, 16)
```

### 3. Auto-Ledger on Fuel Log
Every time a fuel log is created (from either the admin panel or the driver portal), the system **automatically** creates an offsetting `EXPENSE` entry in the ledger:
```php
LedgerTransaction::create([
    'tx_hash'     => '0x' . substr(hash('sha256', time()), 0, 10),
    'truck_unit'  => $truck->unit_number,
    'type'        => 'EXPENSE',
    'description' => 'FUEL AUTO-DEDUCT',
    'amount'      => $request->cost
]);
```

### 4. Auto-VIN Generation
```php
'vin' => 'VIN-' . strtoupper(substr(md5(time() . rand()), 0, 12))
```

### 5. Asset Locking (Driver Portal)
When a driver locks a truck, it sets `current_speed = 85`, which makes it appear as "IN TRANSIT" across the admin dashboard immediately.

### 6. SOS Beacon
Creates a maintenance alert with `wear_percentage = 100` and `component = 'SYSTEM EMERGENCY'`, which surfaces at the top of the AI Maintenance Matrix (sorted by `days_to_failure ASC`).

### 7. Net Margin Calculation
```php
$margin = $revenue > 0 ? (($revenue - $expense) / $revenue) * 100 : 0;
```
Protected against division by zero — shows `0%` when no revenue exists yet.

---

## 📁 Folder Structure

```
fleet-io/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php   # All admin module logic
│   │       ├── DriverPortalController.php # Mobile portal logic
│   │       └── SecurityController.php    # 4-factor auth
│   └── Models/
│       ├── Truck.php                     # hasMany FuelLogs
│       ├── Driver.php
│       ├── FuelLog.php                   # belongsTo Truck
│       ├── MaintenanceAlert.php          # belongsTo Truck
│       ├── LedgerTransaction.php
│       ├── SystemSetting.php
│       └── User.php
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── ...create_trucks_table.php
│       ├── ...create_drivers_table.php
│       ├── ...create_fuel_logs_table.php
│       ├── ...create_maintenance_alerts_table.php
│       ├── ...create_ledger_transactions_table.php
│       ├── ...create_system_settings_table.php
│       └── ...create_personal_access_tokens_table.php
└── resources/
    └── views/
        ├── auth/
        │   └── gateway.blade.php         # 4-factor admin login
        ├── dashboard/
        │   ├── command-center.blade.php  # HQ overview
        │   ├── assets.blade.php          # Truck fleet
        │   ├── fuel.blade.php            # Fuel tracking
        │   ├── drivers.blade.php         # Driver roster
        │   ├── maintenance.blade.php     # AI diagnostics
        │   ├── ledger.blade.php          # Financial ledger
        │   ├── security.blade.php        # Security ops
        │   └── settings.blade.php        # System config
        └── portal/
            ├── login.blade.php           # Driver login (mobile)
            └── mission.blade.php         # Driver dashboard (mobile)
```

---

## 🧑‍💻 Developer Notes

**Blade Component:** A reusable `<x-sidebar>` component is referenced across all admin views with an `active` prop to highlight the current nav item. Ensure this component exists at `resources/views/components/sidebar.blade.php`.

**Alpine.js Modals:** All modal popups (Deploy Asset, Recruit Driver, Log Fuel) are controlled via Alpine.js `x-data` state. The `[x-cloak]` CSS rule `{ display: none !important; }` is required in every page that uses modals to prevent flash-of-content on load.

**Migration Conflict:** The project contains two `fuel_logs` table migrations from different development iterations. When running `migrate:fresh`, Laravel may throw a "table already exists" error. Recommended fix: delete the earlier `2026_05_11_065045_create_fuel_logs_table.php` file and keep only `2026_05_11_185737_create_fuel_logs_table.php`.

**Session Driver:** The project uses database sessions (`sessions` table is created in the users migration). Ensure your `.env` has `SESSION_DRIVER=database`.

**CNIC Validation:** The `strict_cnic_validation` setting in `system_settings` is stored as a boolean and controlled via a CSS checkbox toggle. The form uses `$request->has('strict_cnic_validation')` to handle the checkbox's on/off state correctly.

---

## 📄 License

This project is open-sourced under the [MIT License](LICENSE).

---

<div align="center">

Built with ⚡ by **Muhammad Bilal Ifzal**

*Laravel · Tailwind CSS · Alpine.js · MySQL*

</div>
