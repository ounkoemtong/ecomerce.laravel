# E-Commerce Backend

This backend is a Laravel 12 API for an e-commerce project. It already covers the main store entities like users, roles, products, brands, categories, carts, wishlists, reviews, addresses, orders, payments, and shipping.

The project uses:
- Laravel 12
- PHP 8.2+
- Laravel Sanctum for API authentication
- Cloudinary for product image uploads

## Current Features

Implemented API areas:
- Authentication: register, login, logout
- Catalog: categories, brands, products
- User features: addresses, carts, wishlists, reviews
- Order flow: create order from cart, order listing, order detail
- Admin features: manage users, roles, products, product images, orders, payments, shipping, categories, brands

Current behavior already visible in the code:
- Public product listing supports search, filtering, sorting, and pagination
- Cart price sync respects discount pricing
- Checkout creates order items from the cart and reduces stock
- Admin routes are protected with role middleware

## Project Structure

Important folders:
- `app/Http/Controllers`: API and business flow controllers
- `app/Http/Requests`: validation rules
- `app/Http/Resources`: API response transformers
- `app/Models`: Eloquent models
- `database/migrations`: schema
- `database/seeders`: sample data
- `routes/api.php`: API routes

## Roles

The app currently works with these main roles:
- `admin`: full management access
- `user`: normal customer access

In the current implementation, new users are registered as normal users by default.

## Quick Start

1. Install PHP dependencies:

```bash
composer install
```

2. Create environment file:

```bash
copy .env.example .env
```

3. Generate app key:

```bash
php artisan key:generate
```

4. Configure `.env`:
- database connection
- Cloudinary credentials
- cache/session/queue driver

5. Run migrations and seeders:

```bash
php artisan migrate --seed
```

6. Start the backend:

```bash
php artisan serve
```

7. If using the frontend assets in this backend:

```bash
npm install
npm run dev
```

## Default Development Command

This project includes a combined development script:

```bash
composer run dev
```

It starts:
- Laravel server
- queue listener
- log watcher
- Vite dev server

## Main API Groups

Public routes:
- `POST /api/register`
- `POST /api/login`
- `GET /api/categories`
- `GET /api/brands`
- `GET /api/products`

Authenticated user routes:
- `POST /api/logout`
- `apiResource /api/address`
- `apiResource /api/carts`
- `apiResource /api/reviews`
- `apiResource /api/wishlists`
- `GET|POST|SHOW /api/orders`

Admin routes:
- `apiResource /api/roles`
- `apiResource /api/users`
- write access for categories, brands, products
- `apiResource /api/product-images`
- update and delete for orders
- `apiResource /api/payments`
- `apiResource /api/shippings`

## Useful Product Query Parameters

The product listing currently supports:
- `search`
- `category_id`
- `brand_id`
- `status`
- `min_price`
- `max_price`
- `sort`
- `per_page`

Example:

```text
/api/products?search=shoe&category_id=1&min_price=20&max_price=100&sort=price_low&per_page=12
```

## What Still Needs Work

The backend has a good CRUD foundation, but it still needs stronger production-level workflow logic.

Highest-value gaps:
- ownership validation for things like `address_id` during checkout
- stronger policies so users can only change their own resources
- full payment flow instead of only payment fields
- order cancellation and stock restoration
- consistent API response format
- real automated feature tests
- project-specific API documentation

## Recommended Build Order

If you want to improve this project step by step, this is the order I recommend.

### Phase 1: Stabilize Core Flows

1. Replace weak ownership checks with stricter authorization
2. Validate that checkout address belongs to the authenticated user
3. Make `payment_method` required during checkout
4. Stop trusting client-provided values like shipping fee unless verified by backend logic
5. Add consistent 403 and 422 behavior across controllers

### Phase 2: Complete Order Lifecycle

1. Add order status transitions:
   `pending`, `paid`, `shipped`, `delivered`, `cancelled`
2. Add payment status transitions:
   `pending`, `paid`, `failed`, `refunded`
3. Restore stock when an order is cancelled or fails
4. Add cancellation rules for users and admins
5. Record payment attempts and failures

### Phase 3: Improve Product Experience

1. Add featured products
2. Add review summary and average rating per product
3. Add related products by category or brand
4. Add inventory labels like `in_stock`, `low_stock`, `out_of_stock`
5. Add slug support for cleaner product URLs

### Phase 4: Add Test Coverage

Start with feature tests for:
- register/login/logout
- product listing and filters
- cart create/update/delete
- checkout success
- checkout failure when stock is low
- admin-only route protection

## Suggested Next 3 Days

### Day 1
- clean up README and API understanding
- tighten route protection and ownership checks
- improve `OrderStoreRequest`

### Day 2
- implement order cancellation and stock restoration
- connect payment state with order state
- standardize API responses

### Day 3
- add feature tests for auth, cart, and orders
- document sample requests
- prepare admin dashboard summary endpoints

## Environment Notes

Before running image upload features, make sure Cloudinary values are configured in `.env`.

Before testing authenticated APIs, make sure Sanctum is installed and personal access tokens table has been migrated.

## Current Testing Status

The backend currently appears to still have default example tests, so proper feature coverage should be added before calling the project production-ready.

## Suggested Next Task

The best next coding task for this codebase is:

`secure checkout and ownership validation`

That work would include:
- verifying `address_id` belongs to the current user
- preventing non-admin users from acting on behalf of another user
- tightening order and cart update rules
- adding tests around those flows


don't forget use cloudinary :
composer require cloudinary/cloudinary_php