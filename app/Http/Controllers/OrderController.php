<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderRefundService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->withCount('products')
            ->latest()
            ->get();

        return view('order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorizeOwner($order);
        $order->load(['products.category', 'user']);

        return view('order.show', compact('order'));
    }

    public function update(Order $order)
    {
        $this->authorizeOwner($order);

        return redirect()->route('order.show', $order);
    }

    public function cancel(Order $order, OrderRefundService $refunds)
    {
        $this->authorizeOwner($order);

        if ($order->status !== 'complete') {
            throw ValidationException::withMessages([
                'order' => 'Only completed orders can be refunded.',
            ]);
        }

        $refunds->refund($order);

        return redirect()
            ->route('order.show', $order)
            ->with('success', 'Your refund request has been submitted.');
    }

    private function authorizeOwner(Order $order): void
    {
        abort_unless($order->userId === Auth::id(), 403);
    }
}
