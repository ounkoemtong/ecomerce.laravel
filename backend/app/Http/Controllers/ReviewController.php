<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\ReviewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    private function validateReview(Request $request, bool $isUpdate = false): array
    {
        return Validator::make($request->all(), [
            'product_id' => ($isUpdate ? 'sometimes' : 'required') . '|integer|exists:products,id',
            'order_id' => ($isUpdate ? 'sometimes' : 'required') . '|integer|exists:orders,id',
            'rating' => ($isUpdate ? 'sometimes' : 'required') . '|integer|min:1|max:5',
            'comment' => ($isUpdate ? 'sometimes' : 'required') . '|string',
            'status' => 'sometimes|in:pending,approved,rejected',
        ])->validate();
    }

    private function ensureReviewOrderOwnership(Request $request, int $orderId): ?\Illuminate\Http\JsonResponse
    {
        $order = OrderModel::find($orderId);

        if (!$order) {
            return $this->errorResponse('Order not found.', 404);
        }

        if ($request->user()->role?->name !== 'admin' && $order->user_id !== $request->user()->id) {
            return $this->errorResponse('You do not have permission to review this order.', 403);
        }

        return null;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', ReviewModel::class);

        $query = ReviewModel::query()->latest();

        if ($request->user()->role?->name !== 'admin') {
            $query->where('user_id', $request->user()->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        return $this->successResponse('Reviews found.', [
            'reviews' => $query->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', ReviewModel::class);

        $validated = $this->validateReview($request);
        $ownershipError = $this->ensureReviewOrderOwnership($request, $validated['order_id']);

        if ($ownershipError) {
            return $ownershipError;
        }

        $userId = $request->user()->role?->name === 'admin' && $request->filled('user_id')
            ? (int) $request->user_id
            : (int) $request->user()->id;

        $review = ReviewModel::create([
            'user_id' => $userId,
            'product_id' => $validated['product_id'],
            'order_id' => $validated['order_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => $validated['status'] ?? 'pending',
        ]);

        return $this->successResponse('Review created successfully.', [
            'review' => $review,
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $review = ReviewModel::find($id);

        if (!$review) {
            return $this->errorResponse('Review not found.', 404);
        }

        $this->authorize('view', $review);

        return $this->successResponse('Review found.', [
            'review' => $review,
        ]);
    }

    public function update(Request $request, $id)
    {
        $review = ReviewModel::find($id);

        if (!$review) {
            return $this->errorResponse('Review not found.', 404);
        }

        $this->authorize('update', $review);

        $validated = $this->validateReview($request, true);

        if (isset($validated['order_id'])) {
            $ownershipError = $this->ensureReviewOrderOwnership($request, $validated['order_id']);

            if ($ownershipError) {
                return $ownershipError;
            }
        }

        $review->update(array_merge($validated, [
            'user_id' => $review->user_id,
        ]));

        return $this->successResponse('Review updated successfully.', [
            'review' => $review->fresh(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $review = ReviewModel::find($id);

        if (!$review) {
            return $this->errorResponse('Review not found.', 404);
        }

        $this->authorize('delete', $review);
        $review->delete();

        return $this->successResponse('Review deleted successfully.', [
            'review' => $review,
        ]);
    }
}
