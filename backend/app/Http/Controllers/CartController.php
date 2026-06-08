<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\CartModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class CartController extends Controller
{
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

    private function syncCartPrice(CartModel $cart, ProductModel $product): CartModel
    {
        $finalPrice = $this->getProductPrice($product);

        if ((float) $cart->price !== (float) $finalPrice) {
            $cart->update(['price' => $finalPrice]);
        }

        return $cart->load('product');
    }

    private function stockError(ProductModel $product, int $quantity)
    {
        if ($quantity > $product->stock_qty) {
            return response()->json([
                'success' => false,
                'message' => 'not enough product stock',
                'available_stock' => $product->stock_qty,
            ], 422);
        }

        return null;
    }

    public function index(Request $request)
    {
        $carts = CartModel::with('product')
            ->where('user_id', $request->user()->id)
            ->get()
            ->map(function ($cart) {
                return $cart->product ? $this->syncCartPrice($cart, $cart->product) : $cart;
            });

        return response()->json([
            'success' => true,
            'message' => 'carts found',
            'carts' => CartResource::collection($carts),
        ]);
    }

    public function store(CartRequest $request)
    {
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

        return response()->json([
            'success' => true,
            'message' => 'cart created successfully',
            'cart' => new CartResource($cart->load('product')),
        ], 201);
    }

    public function show($id , Request $request)
    {
        $cart = CartModel::find($id);

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'cart not found',
            ], 404);
        }

        if ($cart->user_id !== $request->user()->id && $request->user()->role?->name !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to access this cart.',
            ], 403);
        }

        $product = ProductModel::find($cart->product_id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'cart product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'cart found',
            'cart' => new CartResource($this->syncCartPrice($cart, $product)),
        ]);
    }

    public function update(CartRequest $request, $id)
    {
        $cart = CartModel::find($id);

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'cart not found',
            ], 404);
        }

        if ($cart->user_id !== $request->user()->id && $request->user()->role?->name !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to update this cart.',
            ], 403);
        }

        $userId = $this->targetUserId($request);
        $product = ProductModel::find($request->product_id);
        $stockError = $this->stockError($product, $request->quantity);

        if ($stockError) {
            return $stockError;
        }

        $price = $this->getProductPrice($product);

        $cart->update([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'cart updated successfully',
            'cart' => new CartResource($cart->load('product')),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $cart = CartModel::find($id);

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'cart not found',
            ], 404);
        }

        if ($cart->user_id !== $request->user()->id && $request->user()->role?->name !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to delete this cart.',
            ], 403);
        }

        $cart->delete();
        return response()->json([
            'success' => true,
            'message' => 'cart deleted successfully',
            'delete' => $cart,
        ]);
    }
}
