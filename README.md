<h1 align="center">Boltify</h1>

Boltify is a Laravel e-commerce application that digitizes the everyday hardware-store experience. It combines a clean customer storefront with a role-protected operations workspace for catalog, inventory, order, refund, category, and customer management.

## What Boltify includes

- **Commercial hardware storefront** with product search, department and price filters, sorting, pagination, product details, related products, and intentional no-photo catalog artwork.
- **Customer accounts** with profile management and order history.
- **Shopping cart** powered by Livewire with live quantities, inventory-aware limits, and order totals.
- **Stripe Checkout** for card payments, Philippine shipping addresses, payment-session verification, and refunds.
- **Inventory-aware orders** that deduct stock after a verified payment and return stock after a successful refund.
- **Admin workspace** for dashboard metrics, six-month revenue, products, categories, orders, refunds, customers, and low-stock monitoring.
- **Admin authorization** through an `is_admin` role flag and middleware.
- **Demo seed data** covering users, categories, products, carts, order history, order lines, stock states, and dashboard activity.

## Stack

- PHP 8.5
- Laravel 13
- Blade
- Livewire 4
- Tailwind CSS 3
- Alpine.js
- Vite
- MySQL
- Stripe PHP SDK

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

4. Prepare the database, seed the demo store, and create the public storage link.

   ```sh
   php artisan migrate
   php artisan db:seed
   php artisan storage:link
   ```

   For a disposable local database you can rebuild everything in one command:

   ```sh
   php artisan migrate:fresh --seed
   ```

5. Start development services.

   ```sh
   composer run dev
   ```

6. Open the storefront at `http://127.0.0.1:8000` or the administration workspace at `/admin`.

## Demo accounts

The seeders create verified accounts so the complete store can be explored without registering first.

| Role | Email | Password |
| --- | --- | --- |
| Administrator | `admin@boltify.test` | `password` |
| Customer | `customer@boltify.test` | `password` |

Additional seeded customer accounts are included to populate purchasing history and admin customer metrics.

> The demo credentials are development data only. Do not seed them into a real production store.

## Administration

The admin area provides an operations dashboard, product and category management, inventory status, order search and filtering, Stripe refunds, and customer purchasing information. Customer accounts cannot access admin routes.

Products may be created without photographs. When no image is available, Boltify uses its technical catalog artwork instead of rendering an empty product card; uploaded product photos automatically replace the fallback artwork.

## Database notes

The schema uses UUID model keys and composite primary keys for the cart and order junction tables. This keeps fresh installs compatible with managed MySQL services that enforce primary keys on every table, including services such as Aiven.

## Validation

The branch CI validates PHP dependencies, dependency security, fresh migrations with the full demo seed, Blade compilation, Laravel tests, and the production Vite build on PHP 8.5.

## Screenshots

The `screenshots/` directory contains images from the original Boltify build. Some images may not represent the expanded admin workspace and current storefront design.
