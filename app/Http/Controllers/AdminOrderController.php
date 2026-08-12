<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderRefundService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = (string) $request->input('status');

        $orders = Order::query()
            ->with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('id', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('payment_intent', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, ['complete', 'refunded', 'pending'], true), fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'search', 'status'));
    }

    public function show(Order $order)
    {
        $order->load(['products.category', 'user']);

        return view('admin.orders.show', compact('order'));
    }

    public function refund(Request $request, Order $order, OrderRefundService $refunds)
    {
        $validated = $request->validate([
            'reason' => ['nullable', 'string', Rule::in(['requested_by_customer', 'duplicate', 'fraudulent', 'requested_by_admin'])],
        ]);

        if ($order->status !== 'complete') {
            return back()->with('error', 'Only completed orders can be refunded.');
        }

        $refunds->refund($order, $validated['reason'] ?? 'requested_by_admin');

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Refund submitted successfully.');
    }
}
