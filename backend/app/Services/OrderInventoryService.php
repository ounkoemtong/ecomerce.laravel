<?php

namespace App\Services;

use App\Models\OrderModel;
use App\Models\ProductModel;
use Illuminate\Support\Facades\Log;

class OrderInventoryService
{
    public function reduceStockForOrder(OrderModel $order): void
    {
        if ($order->stock_reduced_at) {
            return;
        }

        $order->loadMissing('items.product');

        foreach ($order->items as $item) {
            $product = ProductModel::lockForUpdate()->find($item->product_id);

            if (!$product) {
                throw new \RuntimeException("Product {$item->product_id} not found.");
            }

            if ($product->stock_qty < $item->quantity) {
                throw new \RuntimeException("Not enough stock for {$item->product_name}.");
            }

            $product->decrement('stock_qty', $item->quantity);

            if ($product->fresh()->stock_qty <= 5) {
                Log::warning('Product stock is low after order processing.', [
                    'product_id' => $product->id,
                    'remaining_stock' => $product->stock_qty,
                    'order_id' => $order->id,
                ]);
            }
        }

        $order->forceFill(['stock_reduced_at' => now()])->save();
    }

    public function restoreStockForOrder(OrderModel $order): void
    {
        if (!$order->stock_reduced_at) {
            return;
        }

        $order->loadMissing('items.product');

        foreach ($order->items as $item) {
            $product = ProductModel::lockForUpdate()->find($item->product_id);

            if (!$product) {
                Log::error('Unable to restore stock because product is missing.', [
                    'product_id' => $item->product_id,
                    'order_id' => $order->id,
                ]);

                continue;
            }

            $product->increment('stock_qty', $item->quantity);
        }

        $order->forceFill(['stock_reduced_at' => null])->save();
    }
}
