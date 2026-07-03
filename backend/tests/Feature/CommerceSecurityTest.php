<?php

namespace Tests\Feature;

use App\Models\AddressesModel;
use App\Models\BrandModel;
use App\Models\CartModel;
use App\Models\CategoryModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;
use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommerceSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role = 'customer'): User
    {
        $roleModel = RoleModel::query()->firstOrCreate(['name' => $role]);

        return User::factory()->create([
            'role_id' => $roleModel->id,
        ]);
    }

    private function createProduct(int $stock = 10, float $price = 100, ?float $discountPrice = 80): ProductModel
    {
        $category = CategoryModel::create([
            'name' => 'Phones',
            'slug' => 'phones-' . uniqid(),
            'description' => 'Phones',
            'status' => 'active',
        ]);

        $brand = BrandModel::create([
            'name' => 'Acme ' . uniqid(),
            'slug' => 'acme-' . uniqid(),
            'logo' => null,
            'status' => 'active',
        ]);

        return ProductModel::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Phone ' . uniqid(),
            'slug' => 'phone-' . uniqid(),
            'description' => 'A test phone',
            'price' => $price,
            'discount_price' => $discountPrice,
            'stock_qty' => $stock,
            'sku' => 'SKU-' . uniqid(),
            'image' => null,
            'status' => 'active',
        ]);
    }

    private function createAddressFor(User $user): AddressesModel
    {
        return AddressesModel::create([
            'user_id' => $user->id,
            'full_name' => $user->name,
            'phone' => '0123456789',
            'province' => 'Province',
            'city' => 'City',
            'district' => 'District',
            'address_line' => 'Street 123',
            'is_default' => true,
        ]);
    }

    public function test_user_cannot_view_another_users_cart(): void
    {
        $owner = $this->createUser();
        $intruder = $this->createUser();
        $product = $this->createProduct();

        $cart = CartModel::create([
            'user_id' => $owner->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 80,
        ]);

        Sanctum::actingAs($intruder);

        $response = $this->getJson('/api/carts/' . $cart->id);

        $response->assertForbidden();
    }

    public function test_checkout_requires_an_address_owned_by_the_authenticated_user(): void
    {
        $customer = $this->createUser();
        $otherUser = $this->createUser();
        $product = $this->createProduct();
        $foreignAddress = $this->createAddressFor($otherUser);

        CartModel::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 80,
        ]);

        Sanctum::actingAs($customer);

        $response = $this->postJson('/api/orders', [
            'address_id' => $foreignAddress->id,
            'payment_method' => 'credit_card',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'The selected address does not belong to this user.');
    }

    public function test_checkout_recalculates_totals_server_side_and_keeps_stock_until_payment_is_paid(): void
    {
        $customer = $this->createUser();
        $product = $this->createProduct(stock: 5, price: 100, discountPrice: 80);
        $address = $this->createAddressFor($customer);

        CartModel::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 1,
        ]);

        Sanctum::actingAs($customer);

        $response = $this->postJson('/api/orders', [
            'address_id' => $address->id,
            'payment_method' => 'credit_card',
            'shipping_fee' => 99999,
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.order.subtotal', 200)
            ->assertJsonPath('data.order.discount', 40)
            ->assertJsonPath('data.order.shipping_fee', 0)
            ->assertJsonPath('data.order.total', 160);

        $this->assertSame(5, $product->fresh()->stock_qty);
    }

    public function test_paid_payment_reduces_stock_and_refund_restores_it(): void
    {
        $admin = $this->createUser('admin');
        $customer = $this->createUser();
        $product = $this->createProduct(stock: 4, price: 100, discountPrice: 80);
        $address = $this->createAddressFor($customer);

        $order = OrderModel::create([
            'user_id' => $customer->id,
            'address_id' => $address->id,
            'order_number' => 'ORD-TEST-' . uniqid(),
            'subtotal' => 200,
            'discount' => 40,
            'shipping_fee' => 0,
            'total' => 160,
            'payment_status' => OrderModel::PAYMENT_STATUS_PENDING,
            'order_status' => OrderModel::ORDER_STATUS_PENDING,
            'payment_method' => 'credit_card',
        ]);

        OrderItemModel::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => 80,
            'quantity' => 2,
            'total' => 160,
        ]);

        Sanctum::actingAs($admin);

        $createPayment = $this->postJson('/api/payments', [
            'order_id' => $order->id,
            'payment_method' => 'credit_card',
            'amount' => 160,
        ]);

        $createPayment->assertCreated()
            ->assertJsonPath('success', true);

        $paymentId = $createPayment->json('data.payment.id');

        $payResponse = $this->putJson('/api/payments/' . $paymentId, [
            'status' => PaymentModel::STATUS_PAID,
            'transaction_id' => 'txn_123',
        ]);

        $payResponse->assertOk()
            ->assertJsonPath('data.payment.status', PaymentModel::STATUS_PAID);

        $this->assertSame(2, $product->fresh()->stock_qty);
        $this->assertSame(OrderModel::ORDER_STATUS_PAID, $order->fresh()->order_status);

        $refundResponse = $this->putJson('/api/payments/' . $paymentId, [
            'status' => PaymentModel::STATUS_REFUNDED,
            'refund_reason' => 'Customer requested refund',
        ]);

        $refundResponse->assertOk()
            ->assertJsonPath('data.payment.status', PaymentModel::STATUS_REFUNDED);

        $this->assertSame(4, $product->fresh()->stock_qty);
        $this->assertSame(OrderModel::ORDER_STATUS_CANCELLED, $order->fresh()->order_status);
    }

    public function test_registration_is_rate_limited_after_ten_attempts_from_the_same_device(): void
    {
        RoleModel::query()->create(['name' => 'admin']);
        RoleModel::query()->create(['name' => 'customer']);

        $headers = [
            'User-Agent' => 'CommerceSecurityTest/RegisterLimiter',
        ];

        for ($attempt = 1; $attempt <= 10; $attempt++) {
            $response = $this->withHeaders($headers)->postJson('/api/register', [
                'name' => 'Test User ' . $attempt,
                'email' => 'register-limit-' . $attempt . '@example.com',
                'phone' => '01234567' . $attempt,
                'password' => '1234',
            ]);

            $response->assertCreated()
                ->assertJsonPath('success', true);
        }

        $blockedResponse = $this->withHeaders($headers)->postJson('/api/register', [
            'name' => 'Blocked User',
            'email' => 'register-limit-blocked@example.com',
            'phone' => '0123456799',
            'password' => '1234',
        ]);

        $blockedResponse->assertStatus(429)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Too many registration attempts. Please wait a minute and try again.');
    }
}
