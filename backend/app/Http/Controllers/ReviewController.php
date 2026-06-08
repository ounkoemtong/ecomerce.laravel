<?php

namespace App\Http\Controllers;

use App\Models\ReviewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'reviews found',
            'reviews' => ReviewModel::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',
            'order_id' => 'required|integer|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error',
                'error' => $validator->errors(),
            ], 422);
        }

        $review = ReviewModel::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'review created successfully',
            'review' => $review,
        ], 201);
    }

    public function show($id)
    {
        $review = ReviewModel::find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'review not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'review found',
            'review' => $review,
        ]);
    }

    public function update(Request $request, $id)
    {
        $review = ReviewModel::find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'review not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',
            'order_id' => 'required|integer|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error',
                'error' => $validator->errors(),
            ], 422);
        }

        $review->update([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'review updated successfully',
            'review' => $review,
        ]);
    }

    public function destroy($id)
    {
        $review = ReviewModel::find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'review not found',
            ], 404);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'review deleted successfully',
            'delete' => $review,
        ]);
    }
}
