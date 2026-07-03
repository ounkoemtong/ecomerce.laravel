<?php

namespace App\Http\Requests;

use App\Models\OrderModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'payment_status' => ['sometimes', Rule::in([
                OrderModel::PAYMENT_STATUS_PENDING,
                OrderModel::PAYMENT_STATUS_PAID,
                OrderModel::PAYMENT_STATUS_FAILED,
                OrderModel::PAYMENT_STATUS_REFUNDED,
            ])],
            'order_status' => ['sometimes', Rule::in([
                OrderModel::ORDER_STATUS_PENDING,
                OrderModel::ORDER_STATUS_PAID,
                OrderModel::ORDER_STATUS_PROCESSING,
                OrderModel::ORDER_STATUS_SHIPPED,
                OrderModel::ORDER_STATUS_DELIVERED,
                OrderModel::ORDER_STATUS_CANCELLED,
            ])],
        ];
    }
}
