<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function store(ProductRequest $request)
    {
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

        $data = $request->validated();
        unset($data['image']);

        $product = ProductModel::create([
            ...$data,
            'image' => $imageUrl,
            'status' => $data['status'] ?? 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => new ProductResource($product),
        ], 201);
    }

    public function index(Request $request)
    {
        $products = ProductModel::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('brand_id'), fn ($query) => $query->where('brand_id', $request->brand_id))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('min_price'), fn ($query) => $query->where('price', '>=', $request->min_price))
            ->when($request->filled('max_price'), fn ($query) => $query->where('price', '<=', $request->max_price));

        $sort = $request->input('sort', 'newest');

        match ($sort) {
            'price_low' => $products->orderBy('price'),
            'price_high' => $products->orderByDesc('price'),
            'name' => $products->orderBy('name'),
            default => $products->latest(),
        };

        return response()->json([
            'message' => 'product found',
            'products' => ProductResource::collection($products->paginate($request->integer('per_page', 12))),
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
            'product' => new ProductResource($findById)

        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $find = ProductModel::find($id);

        if (!$find) {
            return response()->json([
                'success' => false,
                'message' => 'product not found !'
            ], 404);
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

        $data = $request->validated();
        unset($data['image']);

        $find->update([
            ...$data,
            'image' => $imageUrl,
            'status' => $data['status'] ?? 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'product update successfully',
            'product' => new ProductResource($find->fresh()),

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
