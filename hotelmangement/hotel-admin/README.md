# 🏨 Lisora Grand - Hotel Admin Pro (PHP + MySQL)

Full admin panel built with **PHP (mysqli) + MySQL**, no framework. Single shared
sidebar/header/CSS so all pages match perfectly.

## 🚀 Setup

1. Copy the `hotel-admin/` folder into your server (`htdocs/` for XAMPP,
   `www/` for WAMP, etc.).
2. Open phpMyAdmin and import `database.sql` — it creates the `hotel_admin`
   database and seeds demo data.
3. Edit `includes/db.php` and put your MySQL username + password.
4. Open `http://localhost/hotel-admin/` — it auto-redirects to dashboard.

Default sample login data (passwords are hashed in DB): `admin123`.

## 📁 Files

```
hotel-admin/
├─ database.sql          # MySQL schema + sample data
├─ index.php             # redirect → dashboard
├─ dashboard.php         # KPIs, revenue chart, recent bookings
├─ users.php             # staff CRUD (AJAX)
├─ rooms.php             # rooms CRUD with grid/table view
├─ bookings.php          # reservations + price calculator
├─ payments.php          # transactions, charts, expenses
├─ customers.php         # guests + booking aggregates
├─ reports.php           # yearly analytics
├─ settings.php          # hotel config (key-value)
├─ includes/
│   ├─ db.php            # MySQL connection + helpers
│   ├─ header.php        # shared <head> + sidebar
│   ├─ sidebar.php       # navigation
│   └─ footer.php        # closing tags + JS
└─ assact/
    ├─ style.css         # ALL shared styles
    └─ app.js            # toast, fetch helper, utilities
```

## ✨ Features

- ✅ Real MySQL backend (no demo arrays anymore)
- ✅ Prepared statements (SQL-injection safe)
- ✅ AJAX add/edit/delete on every page
- ✅ Live charts (Chart.js) — revenue, sources, expense breakdown
- ✅ Search, filters, tabs, modals, toasts
- ✅ Same look & feel across all 8 pages
- ✅ Responsive (sidebar collapses on mobile)

## 🔧 Tweak

- DB credentials → `includes/db.php`
- Colors / spacing → `assact/style.css` (one place)
- Sidebar menu → `includes/sidebar.php`
