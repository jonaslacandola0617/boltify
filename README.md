<h1 align="center">Boltify</h1>

Boltify is a Laravel e-commerce application for hardware tools and supplies. It combines a customer-facing storefront with a role-protected administration workspace for catalog, inventory, order, refund, category, and customer management.

## What Boltify includes

- **Responsive storefront** with product search, category and price filters, sorting, pagination, product details, and related products.
- **Customer accounts** powered by Laravel Breeze, including profile and order history.
- **Shopping cart** powered by Livewire with live quantities, inventory-aware limits, and order totals.
- **Stripe Checkout** for card payments, Philippine shipping addresses, payment-session verification, and refunds.
- **Inventory-aware orders** that deduct stock after a verified payment and return stock after a successful refund.
- **Admin workspace** for dashboard metrics, products, categories, orders, refunds, and customers.
- **Admin authorization** through an `is_admin` role flag and middleware. On a fresh installation, the first registered account becomes the initial administrator.

## Stack

- PHP 8.2+
- Laravel 11
- Blade
- Livewire 3
- Tailwind CSS 3
- Alpine.js
- Vite
- MySQL
- Stripe PHP SDK
- Laravel Breeze

## Local setup

1. Install dependencies.

   ```sh
   composer install
   npm install
   ```

2. Create the environment file and application key.

   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure MySQL and Stripe credentials in `.env`.

4. Prepare the database and public storage link.

   ```sh
   php artisan migrate
   php artisan storage:link
   ```

5. Start development services.

   ```sh
   composer run dev
   ```

6. Register the first account. On a new database, that account becomes the initial administrator and can open `/admin`.

## Administration

The admin area provides an overview dashboard, product and category management, inventory status, order search and filtering, Stripe refunds, and customer purchasing information. Customer accounts cannot access admin routes.

## Existing installations

Running the new migrations adds the admin role flag, order inventory tracking, and historical unit-price snapshots. The oldest existing account is promoted to administrator so an upgraded single-store installation keeps access to the management area.

## Screenshots

The `screenshots/` directory contains images from the original Boltify build. Some images may not represent the expanded admin workspace and updated responsive layouts.
