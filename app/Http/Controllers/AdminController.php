<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function overview()
    {
        $completedOrders = Order::query()->where('status', 'complete');

        $stats = [
            'customers' => User::query()->where('is_admin', false)->count(),
            'products' => Product::query()->count(),
            'orders' => (clone $completedOrders)->count(),
            'revenue' => (clone $completedOrders)->sum('total') / 100,
            'refunds' => Order::query()->where('status', 'refunded')->count(),
            'refund_total' => Order::query()->where('status', 'refunded')->sum('total') / 100,
            'low_stock' => Product::query()->where('stock', '<=', 5)->count(),
        ];

        $recentOrders = Order::query()
            ->with('user')
            ->latest()
            ->limit(6)
            ->get();

        $lowStockProducts = Product::query()
            ->with('category')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->limit(6)
            ->get();

        $revenueOrders = Order::query()
            ->where('status', 'complete')
            ->where('created_at', '>=', now()->startOfMonth()->subMonths(5))
            ->get(['total', 'created_at']);

        $monthlyRevenue = collect(range(5, 0))
            ->mapWithKeys(function ($monthsAgo) use ($revenueOrders) {
                $month = now()->startOfMonth()->subMonths($monthsAgo);

                $total = $revenueOrders
                    ->filter(fn ($order) => $order->created_at->isSameMonth($month))
                    ->sum('total') / 100;

                return [$month->format('M Y') => round($total, 2)];
            });

        return view('admin.overview', compact(
            'stats',
            'recentOrders',
            'lowStockProducts',
            'monthlyRevenue'
        ));
    }

    public function users(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $users = User::query()
            ->withCount('orders')
            ->withSum(['orders as lifetime_value' => fn ($query) => $query->where('status', 'complete')], 'total')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }
}
