<?php

namespace App\Http\Controllers;

use App\Models\PaymentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'payments found',
            'payments' => PaymentModel::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|in:pending,paid,failed,refunded',
            'paid_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error',
                'error' => $validator->errors(),
            ], 422);
        }

        $payment = PaymentModel::create([
            'order_id' => $request->order_id,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'status' => $request->status ?? 'pending',
            'paid_at' => $request->paid_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'payment created successfully',
            'payment' => $payment,
        ], 201);
    }

    public function show($id)
    {
        $payment = PaymentModel::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'payment not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'payment found',
            'payment' => $payment,
        ]);
    }

    public function update(Request $request, $id)
    {
        $payment = PaymentModel::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'payment not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,failed,refunded',
            'paid_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error',
                'error' => $validator->errors(),
            ], 422);
        }

        $payment->update([
            'order_id' => $request->order_id,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'status' => $request->status,
            'paid_at' => $request->paid_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'payment updated successfully',
            'payment' => $payment,
        ]);
    }

    public function destroy($id)
    {
        $payment = PaymentModel::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'payment not found',
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'payment deleted successfully',
            'delete' => $payment,
        ]);
    }
}
