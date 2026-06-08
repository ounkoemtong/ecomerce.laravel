<?php

namespace App\Http\Controllers;

use App\Models\ShippingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'shippings found',
            'shippings' => ShippingModel::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
            'courier_name' => 'required|string',
            'tracking_number' => 'nullable|string|unique:shippings,tracking_number',
            'shipping_status' => 'required|in:pending,shipped,in_transit,delivered,failed,returned',
            'shipped_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error',
                'error' => $validator->errors(),
            ], 422);
        }

        $shipping = ShippingModel::create([
            'order_id' => $request->order_id,
            'courier_name' => $request->courier_name,
            'tracking_number' => $request->tracking_number,
            'shipping_status' => $request->shipping_status,
            'shipped_at' => $request->shipped_at,
            'delivered_at' => $request->delivered_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'shipping created successfully',
            'shipping' => $shipping,
        ], 201);
    }

    public function show($id)
    {
        $shipping = ShippingModel::find($id);

        if (!$shipping) {
            return response()->json([
                'success' => false,
                'message' => 'shipping not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'shipping found',
            'shipping' => $shipping,
        ]);
    }

    public function update(Request $request, $id)
    {
        $shipping = ShippingModel::find($id);

        if (!$shipping) {
            return response()->json([
                'success' => false,
                'message' => 'shipping not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
            'courier_name' => 'required|string',
            'tracking_number' => 'nullable|string|unique:shippings,tracking_number,' . $id,
            'shipping_status' => 'required|in:pending,shipped,in_transit,delivered,failed,returned',
            'shipped_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error',
                'error' => $validator->errors(),
            ], 422);
        }

        $shipping->update([
            'order_id' => $request->order_id,
            'courier_name' => $request->courier_name,
            'tracking_number' => $request->tracking_number,
            'shipping_status' => $request->shipping_status,
            'shipped_at' => $request->shipped_at,
            'delivered_at' => $request->delivered_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'shipping updated successfully',
            'shipping' => $shipping,
        ]);
    }

    public function destroy($id)
    {
        $shipping = ShippingModel::find($id);

        if (!$shipping) {
            return response()->json([
                'success' => false,
                'message' => 'shipping not found',
            ], 404);
        }

        $shipping->delete();

        return response()->json([
            'success' => true,
            'message' => 'shipping deleted successfully',
            'delete' => $shipping,
        ]);
    }
}
