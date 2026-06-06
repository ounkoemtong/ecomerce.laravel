<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Throwable;

class ProductController extends Controller
{
    private function uploadProductImage($image): string
    {
        $upload = Cloudinary::uploadApi()->upload($image->getRealPath(), [
            'folder' => 'products',
            'resource_type' => 'image',
        ]);

        return $upload['secure_url'];
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'name' => 'required|string',
            'slug' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'stock_qty' => 'required|integer',
            'sku' => 'required|string|unique:products,sku',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $imageUrl = null;

        if ($request->hasFile('image')) {
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
        }

        $product = ProductModel::create([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock_qty' => $request->stock_qty,
            'sku' => $request->sku,
            'image' => $imageUrl,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function index()
    {
        return response()->json([
            'message' => 'product found',
            'products' => ProductModel::all(),

        ]);
    }

    public function show($id)
    {
        $findById = ProductModel::find($id);

        if (!$findById) {
            return response()->json([
                'message' => ' product not found !'

            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'product found',
            'product' => $findById

        ]);
    }

    public function update(Request $request, $id)
    {
        $find = ProductModel::find($id);

        if (!$find) {
            return response()->json([
                'success' => false,
                'message' => 'product not found !'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'name' => 'required|string',
            'slug' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'stock_qty' => 'required|integer',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validate error',
                'error' => $validator->errors()
            ], 422);
        }

        $imageUrl = $find->image;

        if ($request->hasFile('image')) {
            try {
                $imageUrl = $this->uploadProductImage($request->file('image'));
            } catch (Throwable $e) {
                Log::error('Cloudinary product image upload failed', [
                    'product_id' => $find->id,
                    'error' => $e->getMessage(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Image upload failed. Please check your Cloudinary configuration.',
                    'error' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }
        }

        $find->update([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock_qty' => $request->stock_qty,
            'sku' => $request->sku,
            'image' => $imageUrl,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'product update successfully',

        ]);
    }

    public function destroy($id)
    {
        $find = ProductModel::find($id);

        if (!$find) {
            return response()->json([
                'success' => false,
                'message' => 'product not found !'

            ]);
        }

        $find->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete successfully  !',
            "delete" => $find

        ]);
    }
}
