<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Stripe\Refund;
use Stripe\Stripe;

class OrderRefundService
{
    public function refund(Order $order, string $reason = 'requested_by_customer'): Order
    {
        if ($order->status === 'refunded' || $order->refund) {
            throw ValidationException::withMessages(['order' => 'This order has already been refunded.']);
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $refund = Refund::create(['payment_intent' => $order->payment_intent]);

        return DB::transaction(function () use ($order, $refund, $reason) {
            $order->loadMissing('products');
            $order->update([
                'refund' => $refund->id,
                'refund_status' => $refund->status,
                'refund_reason' => $reason,
                'refund_completed_at' => $refund->status === 'succeeded' ? now() : null,
                'status' => $refund->status === 'succeeded' ? 'refunded' : $order->status,
            ]);

            if ($refund->status === 'succeeded' && $order->stock_deducted) {
                foreach ($order->products as $product) $product->increment('stock', $product->pivot->quantity);
                $order->update(['stock_deducted' => false]);
            }

            return $order->fresh(['products', 'user']);
        });
    }
}
