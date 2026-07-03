<?php

namespace App\Http\Controllers;

use App\Models\WishListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishListController extends Controller
{
    private function validateWishlist(Request $request): array
    {
        return Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
        ])->validate();
    }

    public function store(Request $request)
    {
        $this->authorize('create', WishListModel::class);

        $validated = $this->validateWishlist($request);
        $userId = $request->user()->role?->name === 'admin' && $request->filled('user_id')
            ? (int) $request->user_id
            : (int) $request->user()->id;

        $wishlist = WishListModel::firstOrCreate([
            'user_id' => $userId,
            'product_id' => $validated['product_id'],
        ]);

        return $this->successResponse('Wishlist item saved successfully.', [
            'wishlist' => $wishlist,
        ], 201);
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', WishListModel::class);

        $query = WishListModel::query()->latest();

        if ($request->user()->role?->name !== 'admin') {
            $query->where('user_id', $request->user()->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        return $this->successResponse('Wishlist items found.', [
            'wishlists' => $query->get(),
        ]);
    }

    public function show(Request $request, $id)
    {
        $wishlist = WishListModel::find($id);

        if (!$wishlist) {
            return $this->errorResponse('Wishlist item not found.', 404);
        }

        $this->authorize('view', $wishlist);

        return $this->successResponse('Wishlist item found.', [
            'wishlist' => $wishlist,
        ]);
    }

    public function update(Request $request, $id)
    {
        $wishlist = WishListModel::find($id);

        if (!$wishlist) {
            return $this->errorResponse('Wishlist item not found.', 404);
        }

        $this->authorize('update', $wishlist);

        $validated = $this->validateWishlist($request);
        $wishlist->update([
            'user_id' => $wishlist->user_id,
            'product_id' => $validated['product_id'],
        ]);

        return $this->successResponse('Wishlist item updated successfully.', [
            'wishlist' => $wishlist->fresh(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $wishlist = WishListModel::find($id);

        if (!$wishlist) {
            return $this->errorResponse('Wishlist item not found.', 404);
        }

        $this->authorize('delete', $wishlist);
        $wishlist->delete();

        return $this->successResponse('Wishlist item deleted successfully.', [
            'wishlist' => $wishlist,
        ]);
    }
}
