<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $orderId = $this->route('order') ?? $this->route('id');

        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'address_id' => ['required', 'integer', 'exists:addresses,id'],
            'order_number' => ['required', 'string', Rule::unique('orders', 'order_number')->ignore($orderId)],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'discount' => ['required', 'numeric', 'min:0'],
            'shipping_fee' => ['required', 'numeric', 'min:0'],
            'total' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', Rule::in(['pending', 'paid', 'failed', 'refunded'])],
            'order_status' => ['required', Rule::in(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])],
            'payment_method' => ['required', Rule::in(['cash_on_delivery', 'aba', 'credit_card', 'paypal'])],
        ];
    }
}
