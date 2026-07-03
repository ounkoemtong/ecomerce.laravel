<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\AddressesModel;
use App\Models\CartModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Services\OrderInventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderInventoryService $inventoryService
    ) {
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);
        } while (OrderModel::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    private function getProductPrice(ProductModel $product): float
    {
        if ($product->discount_price && $product->discount_price < $product->price) {
            return (float) $product->discount_price;
        }

        return (float) $product->price;
    }

    private function targetUserId(Request $request): int
    {
        if ($request->user()->role?->name === 'admin' && $request->filled('user_id')) {
            return (int) $request->user_id;
        }

        return (int) $request->user()->id;
    }

    private function shippingFeeFor(AddressesModel $address): float
    {
        return 0.0;
    }

    private function validateOrderStatusTransition(OrderModel $order, ?string $nextStatus): ?string
    {
        if ($nextStatus === null || $nextStatus === $order->order_status) {
            return null;
        }

        $allowedTransitions = [
            OrderModel::ORDER_STATUS_PENDING => [
                OrderModel::ORDER_STATUS_PAID,
                OrderModel::ORDER_STATUS_PROCESSING,
                OrderModel::ORDER_STATUS_CANCELLED,
            ],
            OrderModel::ORDER_STATUS_PAID => [
                OrderModel::ORDER_STATUS_PROCESSING,
                OrderModel::ORDER_STATUS_CANCELLED,
            ],
            OrderModel::ORDER_STATUS_PROCESSING => [
                OrderModel::ORDER_STATUS_SHIPPED,
                OrderModel::ORDER_STATUS_CANCELLED,
            ],
            OrderModel::ORDER_STATUS_SHIPPED => [
                OrderModel::ORDER_STATUS_DELIVERED,
            ],
            OrderModel::ORDER_STATUS_DELIVERED => [],
            OrderModel::ORDER_STATUS_CANCELLED => [],
        ];

        return in_array($nextStatus, $allowedTransitions[$order->order_status] ?? [], true)
            ? null
            : 'Invalid order status transition.';
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', OrderModel::class);

        $query = OrderModel::with('items')->latest();

        if ($request->user()->role?->name !== 'admin') {
            $query->where('user_id', $request->user()->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        return $this->successResponse('Orders found.', [
            'orders' => OrderResource::collection($query->paginate($request->integer('per_page', 12))),
        ]);
    }

    public function store(OrderStoreRequest $request)
    {
        $this->authorize('create', OrderModel::class);

        $userId = $this->targetUserId($request);
        $address = AddressesModel::where('id', $request->address_id)
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return $this->errorResponse('The selected address does not belong to this user.', 422);
        }

        $carts = CartModel::where('user_id', $userId)->get();

        if ($carts->isEmpty()) {
            return $this->errorResponse('Cart is empty.', 422);
        }

        try {
            $order = DB::transaction(function () use ($request, $carts, $userId, $address) {
                $subtotal = 0.0;
                $discount = 0.0;
                $shippingFee = $this->shippingFeeFor($address);
                $orderItems = [];

                foreach ($carts as $cart) {
                    $product = ProductModel::lockForUpdate()->find($cart->product_id);

                    if (!$product) {
                        throw new \RuntimeException('Product not found.');
                    }

                    if ($cart->quantity > $product->stock_qty) {
                        throw new \RuntimeException('Not enough stock for ' . $product->name . '.');
                    }

                    $originalPrice = (float) $product->price;
                    $finalPrice = $this->getProductPrice($product);
                    $discountAmount = max($originalPrice - $finalPrice, 0);

                    $subtotal += $originalPrice * $cart->quantity;
                    $discount += $discountAmount * $cart->quantity;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $finalPrice,
                        'quantity' => $cart->quantity,
                        'total' => $finalPrice * $cart->quantity,
                    ];
                }

                $total = $subtotal - $discount + $shippingFee;

                $order = OrderModel::create([
                    'user_id' => $userId,
                    'address_id' => $address->id,
                    'order_number' => $this->generateOrderNumber(),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'shipping_fee' => $shippingFee,
                    'total' => $total,
                    'payment_status' => OrderModel::PAYMENT_STATUS_PENDING,
                    'order_status' => OrderModel::ORDER_STATUS_PENDING,
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

                if ($order->payment_method === 'cash_on_delivery') {
                    $this->inventoryService->reduceStockForOrder($order);
                }

                CartModel::where('user_id', $userId)->delete();

                return $order;
            });
        } catch (Throwable $e) {
            Log::error('Order checkout failed.', [
                'user_id' => $userId,
                'address_id' => $request->address_id,
                'message' => $e->getMessage(),
            ]);

            return $this->errorResponse($e->getMessage(), 422);
        }

        return $this->successResponse('Order created successfully.', [
            'order' => new OrderResource($order->load('items')),
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $order = OrderModel::with('items')->find($id);

        if (!$order) {
            return $this->errorResponse('Order not found.', 404);
        }

        $this->authorize('view', $order);

        return $this->successResponse('Order found.', [
            'order' => new OrderResource($order),
        ]);
    }

    public function update(OrderUpdateRequest $request, $id)
    {
        $order = OrderModel::with('items')->find($id);

        if (!$order) {
            return $this->errorResponse('Order not found.', 404);
        }

        $this->authorize('update', $order);

        $validated = $request->validated();
        $transitionError = $this->validateOrderStatusTransition($order, $validated['order_status'] ?? null);

        if ($transitionError) {
            return $this->errorResponse($transitionError, 422);
        }

        try {
            DB::transaction(function () use ($order, $validated) {
                if (($validated['order_status'] ?? null) === OrderModel::ORDER_STATUS_CANCELLED) {
                    $this->inventoryService->restoreStockForOrder($order);
                    $validated['payment_status'] = $validated['payment_status'] ?? OrderModel::PAYMENT_STATUS_FAILED;
                }

                if (($validated['payment_status'] ?? null) === OrderModel::PAYMENT_STATUS_PAID) {
                    $this->inventoryService->reduceStockForOrder($order);
                    $validated['order_status'] = $validated['order_status'] ?? OrderModel::ORDER_STATUS_PAID;
                }

                if (in_array($validated['payment_status'] ?? null, [
                    OrderModel::PAYMENT_STATUS_FAILED,
                    OrderModel::PAYMENT_STATUS_REFUNDED,
                ], true)) {
                    $this->inventoryService->restoreStockForOrder($order);
                    $validated['order_status'] = $validated['order_status'] ?? OrderModel::ORDER_STATUS_CANCELLED;
                }

                $order->update($validated);
            });
        } catch (Throwable $e) {
            Log::error('Order update failed.', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
            ]);

            return $this->errorResponse($e->getMessage(), 422);
        }

        return $this->successResponse('Order updated successfully.', [
            'order' => new OrderResource($order->fresh('items')),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $order = OrderModel::with('items')->find($id);

        if (!$order) {
            return $this->errorResponse('Order not found.', 404);
        }

        $this->authorize('delete', $order);

        DB::transaction(function () use ($order) {
            $this->inventoryService->restoreStockForOrder($order);
            $order->delete();
        });

        return $this->successResponse('Order deleted successfully.', [
            'order' => $order,
        ]);
    }
}
