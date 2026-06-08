<?php

namespace App\Http\Controllers;

use App\Models\ProductImageModel;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProductImageController extends Controller
{
    private function uploadProductImage($image): string
    {
        $upload = Cloudinary::uploadApi()->upload($image->getRealPath(), [
            'folder' => 'product-images',
            'resource_type' => 'image',
        ]);

        return $upload['secure_url'];
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'product images found',
            'product_images' => ProductImageModel::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error',
                'error' => $validator->errors(),
            ], 422);
        }

        try {
            $imageUrl = $this->uploadProductImage($request->file('image'));
        } catch (Throwable $e) {
            Log::error('Cloudinary product image upload failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Image upload failed. Please check your Cloudinary configuration.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }

        $productImage = ProductImageModel::create([
            'product_id' => $request->product_id,
            'image' => $imageUrl,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'product image created successfully',
            'product_image' => $productImage,
        ], 201);
    }

    public function show($id)
    {
        $productImage = ProductImageModel::find($id);

        if (!$productImage) {
            return response()->json([
                'success' => false,
                'message' => 'product image not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'product image found',
            'product_image' => $productImage,
        ]);
    }

    public function update(Request $request, $id)
    {
        $productImage = ProductImageModel::find($id);

        if (!$productImage) {
            return response()->json([
                'success' => false,
                'message' => 'product image not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error',
                'error' => $validator->errors(),
            ], 422);
        }

        $imageUrl = $productImage->image;

        if ($request->hasFile('image')) {
            try {
                $imageUrl = $this->uploadProductImage($request->file('image'));
            } catch (Throwable $e) {
                Log::error('Cloudinary product image upload failed', [
                    'product_image_id' => $productImage->id,
                    'error' => $e->getMessage(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Image upload failed. Please check your Cloudinary configuration.',
                    'error' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }
        }

        $productImage->update([
            'product_id' => $request->product_id,
            'image' => $imageUrl,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'product image updated successfully',
            'product_image' => $productImage,
        ]);
    }

    public function destroy($id)
    {
        $productImage = ProductImageModel::find($id);

        if (!$productImage) {
            return response()->json([
                'success' => false,
                'message' => 'product image not found',
            ], 404);
        }

        $productImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'product image deleted successfully',
            'delete' => $productImage,
        ]);
    }
}
