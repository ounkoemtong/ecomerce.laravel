<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Services\OrderInventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class PaymentController extends Controller
{
    public function __construct(
        private readonly OrderInventoryService $inventoryService
    ) {
    }

    private function validatePayment(Request $request, bool $isUpdate = false): array
    {
        return Validator::make($request->all(), [
            'order_id' => ($isUpdate ? 'sometimes' : 'required') . '|integer|exists:orders,id',
            'payment_method' => ($isUpdate ? 'sometimes' : 'required') . '|string',
            'transaction_id' => 'nullable|string|max:255',
            'payment_intent_id' => 'nullable|string|max:255',
            'amount' => ($isUpdate ? 'sometimes' : 'required') . '|numeric|min:0',
            'status' => ['sometimes', Rule::in([
                PaymentModel::STATUS_PENDING,
                PaymentModel::STATUS_PAID,
                PaymentModel::STATUS_FAILED,
                PaymentModel::STATUS_REFUNDED,
            ])],
            'paid_at' => 'nullable|date',
            'verified_at' => 'nullable|date',
            'failure_reason' => 'nullable|string',
            'refund_reference' => 'nullable|string|max:255',
            'refund_reason' => 'nullable|string',
            'refunded_at' => 'nullable|date',
        ])->validate();
    }

    public function index()
    {
        return $this->successResponse('Payments found.', [
            'payments' => PaymentModel::with('order')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayment($request);
        $order = OrderModel::find($validated['order_id']);

        if (!$order) {
            return $this->errorResponse('Order not found.', 404);
        }

        if ((float) $validated['amount'] !== (float) $order->total) {
            return $this->errorResponse('Payment amount must match the server-calculated order total.', 422);
        }

        $payment = PaymentModel::create([
            'order_id' => $order->id,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'payment_intent_id' => $validated['payment_intent_id'] ?? ('pi_' . uniqid()),
            'amount' => $order->total,
            'status' => $validated['status'] ?? PaymentModel::STATUS_PENDING,
            'paid_at' => $validated['paid_at'] ?? null,
            'verified_at' => $validated['verified_at'] ?? null,
            'failure_reason' => $validated['failure_reason'] ?? null,
            'refund_reference' => $validated['refund_reference'] ?? null,
            'refund_reason' => $validated['refund_reason'] ?? null,
            'refunded_at' => $validated['refunded_at'] ?? null,
        ]);

        return $this->successResponse('Payment intent created successfully.', [
            'payment' => $payment->load('order'),
        ], 201);
    }

    public function show($id)
    {
        $payment = PaymentModel::with('order')->find($id);

        if (!$payment) {
            return $this->errorResponse('Payment not found.', 404);
        }

        return $this->successResponse('Payment found.', [
            'payment' => $payment,
        ]);
    }

    public function update(Request $request, $id)
    {
        $payment = PaymentModel::with('order.items')->find($id);

        if (!$payment) {
            return $this->errorResponse('Payment not found.', 404);
        }

        $validated = $this->validatePayment($request, true);
        $nextStatus = $validated['status'] ?? $payment->status;

        try {
            DB::transaction(function () use ($payment, $validated, $nextStatus) {
                $order = $payment->order;

                if (!$order) {
                    throw new \RuntimeException('Payment order not found.');
                }

                if (array_key_exists('amount', $validated) && (float) $validated['amount'] !== (float) $order->total) {
                    throw new \RuntimeException('Payment amount must match the server-calculated order total.');
                }

                $payment->update([
                    'order_id' => $payment->order_id,
                    'payment_method' => $validated['payment_method'] ?? $payment->payment_method,
                    'transaction_id' => $validated['transaction_id'] ?? $payment->transaction_id,
                    'payment_intent_id' => $validated['payment_intent_id'] ?? $payment->payment_intent_id,
                    'amount' => $order->total,
                    'status' => $nextStatus,
                    'paid_at' => $nextStatus === PaymentModel::STATUS_PAID
                        ? ($validated['paid_at'] ?? now())
                        : ($validated['paid_at'] ?? $payment->paid_at),
                    'verified_at' => $nextStatus === PaymentModel::STATUS_PAID
                        ? ($validated['verified_at'] ?? now())
                        : ($validated['verified_at'] ?? $payment->verified_at),
                    'failure_reason' => $validated['failure_reason'] ?? $payment->failure_reason,
                    'refund_reference' => $validated['refund_reference'] ?? $payment->refund_reference,
                    'refund_reason' => $validated['refund_reason'] ?? $payment->refund_reason,
                    'refunded_at' => $nextStatus === PaymentModel::STATUS_REFUNDED
                        ? ($validated['refunded_at'] ?? now())
                        : ($validated['refunded_at'] ?? $payment->refunded_at),
                ]);

                if ($nextStatus === PaymentModel::STATUS_PAID) {
                    $this->inventoryService->reduceStockForOrder($order);
                    $order->update([
                        'payment_status' => OrderModel::PAYMENT_STATUS_PAID,
                        'order_status' => OrderModel::ORDER_STATUS_PAID,
                    ]);
                }

                if ($nextStatus === PaymentModel::STATUS_FAILED) {
                    $this->inventoryService->restoreStockForOrder($order);
                    $order->update([
                        'payment_status' => OrderModel::PAYMENT_STATUS_FAILED,
                        'order_status' => OrderModel::ORDER_STATUS_CANCELLED,
                    ]);
                }

                if ($nextStatus === PaymentModel::STATUS_REFUNDED) {
                    $this->inventoryService->restoreStockForOrder($order);
                    $order->update([
                        'payment_status' => OrderModel::PAYMENT_STATUS_REFUNDED,
                        'order_status' => OrderModel::ORDER_STATUS_CANCELLED,
                    ]);
                }
            });
        } catch (Throwable $e) {
            Log::error('Payment update failed.', [
                'payment_id' => $payment->id,
                'message' => $e->getMessage(),
            ]);

            return $this->errorResponse($e->getMessage(), 422);
        }

        return $this->successResponse('Payment updated successfully.', [
            'payment' => $payment->fresh()->load('order'),
        ]);
    }

    public function destroy($id)
    {
        $payment = PaymentModel::find($id);

        if (!$payment) {
            return $this->errorResponse('Payment not found.', 404);
        }

        $payment->delete();

        return $this->successResponse('Payment deleted successfully.', [
            'payment' => $payment,
        ]);
    }
}
