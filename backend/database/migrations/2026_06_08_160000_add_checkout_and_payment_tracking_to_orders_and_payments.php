<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('stock_reduced_at')->nullable()->after('payment_method');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_intent_id')->nullable()->after('transaction_id');
            $table->timestamp('verified_at')->nullable()->after('paid_at');
            $table->text('failure_reason')->nullable()->after('verified_at');
            $table->string('refund_reference')->nullable()->after('failure_reason');
            $table->text('refund_reason')->nullable()->after('refund_reference');
            $table->timestamp('refunded_at')->nullable()->after('refund_reason');
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("
                ALTER TABLE orders
                MODIFY order_status ENUM('pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled')
                NOT NULL DEFAULT 'pending'
            ");
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');

            DB::statement("
                CREATE TABLE orders_temp (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    user_id INTEGER NOT NULL,
                    address_id INTEGER NOT NULL,
                    order_number VARCHAR NOT NULL,
                    subtotal NUMERIC NOT NULL,
                    discount NUMERIC NOT NULL,
                    shipping_fee NUMERIC NOT NULL,
                    total NUMERIC NOT NULL,
                    payment_status VARCHAR CHECK(payment_status IN ('pending','paid','failed','refunded')) NOT NULL DEFAULT 'pending',
                    order_status VARCHAR CHECK(order_status IN ('pending','paid','processing','shipped','delivered','cancelled')) NOT NULL DEFAULT 'pending',
                    payment_method VARCHAR CHECK(payment_method IN ('cash_on_delivery','aba','credit_card','paypal')) NOT NULL DEFAULT 'cash_on_delivery',
                    created_at DATETIME NULL,
                    updated_at DATETIME NULL,
                    stock_reduced_at DATETIME NULL,
                    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY(address_id) REFERENCES addresses(id) ON DELETE CASCADE
                )
            ");

            DB::statement("
                INSERT INTO orders_temp (
                    id, user_id, address_id, order_number, subtotal, discount, shipping_fee, total,
                    payment_status, order_status, payment_method, created_at, updated_at, stock_reduced_at
                )
                SELECT
                    id, user_id, address_id, order_number, subtotal, discount, shipping_fee, total,
                    payment_status, order_status, payment_method, created_at, updated_at, stock_reduced_at
                FROM orders
            ");

            Schema::drop('orders');
            DB::statement('ALTER TABLE orders_temp RENAME TO orders');
            DB::statement('CREATE UNIQUE INDEX orders_order_number_unique ON orders(order_number)');
            DB::statement('PRAGMA foreign_keys=ON');
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("
                ALTER TABLE orders
                MODIFY order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled')
                NOT NULL DEFAULT 'pending'
            ");
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');

            DB::statement("
                CREATE TABLE orders_temp (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    user_id INTEGER NOT NULL,
                    address_id INTEGER NOT NULL,
                    order_number VARCHAR NOT NULL,
                    subtotal NUMERIC NOT NULL,
                    discount NUMERIC NOT NULL,
                    shipping_fee NUMERIC NOT NULL,
                    total NUMERIC NOT NULL,
                    payment_status VARCHAR CHECK(payment_status IN ('pending','paid','failed','refunded')) NOT NULL DEFAULT 'pending',
                    order_status VARCHAR CHECK(order_status IN ('pending','processing','shipped','delivered','cancelled')) NOT NULL DEFAULT 'pending',
                    payment_method VARCHAR CHECK(payment_method IN ('cash_on_delivery','aba','credit_card','paypal')) NOT NULL DEFAULT 'cash_on_delivery',
                    created_at DATETIME NULL,
                    updated_at DATETIME NULL,
                    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY(address_id) REFERENCES addresses(id) ON DELETE CASCADE
                )
            ");

            DB::statement("
                INSERT INTO orders_temp (
                    id, user_id, address_id, order_number, subtotal, discount, shipping_fee, total,
                    payment_status, order_status, payment_method, created_at, updated_at
                )
                SELECT
                    id, user_id, address_id, order_number, subtotal, discount, shipping_fee, total,
                    payment_status,
                    CASE WHEN order_status = 'paid' THEN 'pending' ELSE order_status END,
                    payment_method, created_at, updated_at
                FROM orders
            ");

            Schema::drop('orders');
            DB::statement('ALTER TABLE orders_temp RENAME TO orders');
            DB::statement('CREATE UNIQUE INDEX orders_order_number_unique ON orders(order_number)');
            DB::statement('PRAGMA foreign_keys=ON');
        }

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'payment_intent_id',
                'verified_at',
                'failure_reason',
                'refund_reference',
                'refund_reason',
                'refunded_at',
            ]);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('stock_reduced_at');
        });
    }
};
