<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\CartModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class CartController extends Controller
{
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

    private function syncCartPrice(CartModel $cart, ProductModel $product): CartModel
    {
        $finalPrice = $this->getProductPrice($product);

        if ((float) $cart->price !== $finalPrice) {
            $cart->update(['price' => $finalPrice]);
        }

        return $cart->load('product');
    }

    private function stockError(?ProductModel $product, int $quantity)
    {
        if (!$product) {
            return $this->errorResponse('Product not found.', 404);
        }

        if ($quantity > $product->stock_qty) {
            return $this->errorResponse('Not enough product stock.', 422, [], [
                'available_stock' => $product->stock_qty,
            ]);
        }

        return null;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', CartModel::class);

        $carts = CartModel::with('product')
            ->where('user_id', $request->user()->id)
            ->get()
            ->map(function (CartModel $cart) {
                return $cart->product ? $this->syncCartPrice($cart, $cart->product) : $cart;
            });

        return $this->successResponse('Carts found.', [
            'carts' => CartResource::collection($carts),
        ]);
    }

    public function store(CartRequest $request)
    {
        $this->authorize('create', CartModel::class);

        $userId = $this->targetUserId($request);
        $product = ProductModel::find($request->product_id);
        $cart = CartModel::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        $quantity = $cart ? $cart->quantity + $request->quantity : $request->quantity;
        $stockError = $this->stockError($product, $quantity);

        if ($stockError) {
            return $stockError;
        }

        $price = $this->getProductPrice($product);

        if ($cart) {
            $cart->update([
                'quantity' => $quantity,
                'price' => $price,
            ]);
        } else {
            $cart = CartModel::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        return $this->successResponse('Cart saved successfully.', [
            'cart' => new CartResource($cart->load('product')),
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $cart = CartModel::find($id);

        if (!$cart) {
            return $this->errorResponse('Cart not found.', 404);
        }

        $this->authorize('view', $cart);

        $product = ProductModel::find($cart->product_id);

        if (!$product) {
            return $this->errorResponse('Cart product not found.', 404);
        }

        return $this->successResponse('Cart found.', [
            'cart' => new CartResource($this->syncCartPrice($cart, $product)),
        ]);
    }

    public function update(CartRequest $request, $id)
    {
        $cart = CartModel::find($id);

        if (!$cart) {
            return $this->errorResponse('Cart not found.', 404);
        }

        $this->authorize('update', $cart);

        $product = ProductModel::find($request->product_id);
        $stockError = $this->stockError($product, $request->quantity);

        if ($stockError) {
            return $stockError;
        }

        $cart->update([
            'user_id' => $cart->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $this->getProductPrice($product),
        ]);

        return $this->successResponse('Cart updated successfully.', [
            'cart' => new CartResource($cart->load('product')),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $cart = CartModel::find($id);

        if (!$cart) {
            return $this->errorResponse('Cart not found.', 404);
        }

        $this->authorize('delete', $cart);

        $cart->delete();

        return $this->successResponse('Cart deleted successfully.', [
            'cart' => $cart,
        ]);
    }
}
