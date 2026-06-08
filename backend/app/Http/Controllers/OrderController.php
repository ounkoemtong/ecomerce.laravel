<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\CartModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);
        } while (OrderModel::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    private function getProductPrice(ProductModel $product)
    {
        if ($product->discount_price && $product->discount_price < $product->price) {
            return $product->price - $product->discount_price;
        }

        return $product->price;
    }

    private function targetUserId(Request $request): int
    {
        $user = $request->user();
        $isAdmin = $user && $user->role && $user->role->name === 'admin';

        if ($isAdmin && $request->filled('user_id')) {
            return (int) $request->user_id;
        }

        return (int) $user->id;
    }

    private function canAccessOrder(Request $request, OrderModel $order): bool
    {
        $user = $request->user();

        return $user->role?->name === 'admin' || $order->user_id === $user->id;
    }

    public function index(Request $request)
    {
        $query = OrderModel::with('items')->latest();

        if ($request->user()->role?->name !== 'admin') {
            $query->where('user_id', $request->user()->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json([
            'success' => true,
            'message' => 'orders found',
            'orders' => OrderResource::collection($query->paginate($request->integer('per_page', 12))),
        ]);
    }

    public function store(OrderStoreRequest $request)
    {
        $userId = $this->targetUserId($request);
        $carts = CartModel::where('user_id', $userId)->get();

        if ($carts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'cart is empty',
            ], 422);
        }

        try {
            $order = DB::transaction(function () use ($request, $carts, $userId) {
                $subtotal = 0;
                $discount = 0;
                $shippingFee = $request->shipping_fee ?? 0;
                $orderItems = [];

                foreach ($carts as $cart) {
                    $product = ProductModel::lockForUpdate()->find($cart->product_id);

                    if (!$product) {
                        throw new \Exception('product not found');
                    }

                    if ($cart->quantity > $product->stock_qty) {
                        throw new \Exception('not enough stock for ' . $product->name);
                    }

                    $originalPrice = $product->price;
                    $finalPrice = $this->getProductPrice($product);
                    $discountAmount = $originalPrice - $finalPrice;

                    $subtotal += $originalPrice * $cart->quantity;
                    $discount += $discountAmount * $cart->quantity;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $finalPrice,
                        'quantity' => $cart->quantity,
                        'total' => $finalPrice * $cart->quantity,
                    ];

                    $product->decrement('stock_qty', $cart->quantity);
                }

                $total = $subtotal - $discount + $shippingFee;

                $order = OrderModel::create([
                    'user_id' => $userId,
                    'address_id' => $request->address_id,
                    'order_number' => $this->generateOrderNumber(),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'shipping_fee' => $shippingFee,
                    'total' => $total,
                    'payment_status' => 'pending',
                    'order_status' => 'pending',
                    'payment_method' => $request->payment_method ?? 'cash_on_delivery',
                ]);

                foreach ($orderItems as $item) {
                    OrderItemModel::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'product_name' => $item['product_name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'total' => $item['total'],
                    ]);
                }

                CartModel::where('user_id', $userId)->delete();

                return $order;
            });
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'order created successfully',
            'order' => new OrderResource($order->load('items')),
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $order = OrderModel::with('items')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'order not found',
            ], 404);
        }

        if (!$this->canAccessOrder($request, $order)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to access this order.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'order found',
            'order' => new OrderResource($order),
        ]);
    }

    public function update(OrderUpdateRequest $request, $id)
    {
        $order = OrderModel::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'order not found',
            ], 404);
        }

        $order->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'order updated successfully',
            'order' => new OrderResource($order->fresh('items')),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $order = OrderModel::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'order not found',
            ], 404);
        }

        if (!$this->canAccessOrder($request, $order)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to delete this order.',
            ], 403);
        }

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'order deleted successfully',
            'delete' => $order,
        ]);
    }
}
