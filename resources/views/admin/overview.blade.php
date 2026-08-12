<x-admin-layout>
    <div class="flex flex-col gap-4 border-b border-zinc-200 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-500"></span><p class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Store operations / Live</p></div>
            <h1 class="mt-2 text-3xl font-extrabold tracking-[-0.05em] text-zinc-950 sm:text-4xl">Command center</h1>
            <p class="mt-1 text-sm text-zinc-500">Sales, customers, catalog health, and inventory at a glance.</p>
        </div>
        <a href="{{ route('admin.product.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950"><i data-feather="package" class="h-4 w-4"></i>Manage catalog</a>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['Revenue','₱'.number_format($stats['revenue'],2),'Completed sales','trending-up'],
            ['Products',number_format($stats['products']),$stats['low_stock'].' need attention','package'],
            ['Customers',number_format($stats['customers']),$stats['orders'].' completed orders','users'],
            ['Refunded','₱'.number_format($stats['refund_total'],2),$stats['refunds'].' refunded orders','rotate-ccw']
        ] as $card)
            <div class="hardware-panel rounded-2xl border border-zinc-200 bg-white p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.15em] text-zinc-400">{{ $card[0] }}</p>
                        <p class="mt-2 text-2xl font-extrabold tracking-[-0.04em] text-zinc-950">{{ $card[1] }}</p>
                        <p class="mt-1 text-[11px] text-zinc-400">{{ $card[2] }}</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-100"><i data-feather="{{ $card[3] }}" class="h-4 w-4 stroke-orange-700"></i></span>
                </div>
            </div>
        @endforeach
    </div>

    @php($maxRevenue = max(1, (float) $monthlyRevenue->max()))
    <section class="hardware-panel overflow-hidden rounded-2xl border border-zinc-200 bg-white">
        <div class="flex flex-col gap-3 border-b border-zinc-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-orange-600">Performance</p>
                <h2 class="mt-0.5 text-base font-extrabold text-zinc-900">Six-month revenue</h2>
            </div>
            <p class="text-xs text-zinc-400">Completed orders only</p>
        </div>
        <div class="px-5 pb-5 pt-7">
            <div class="grid h-48 grid-cols-6 items-end gap-3 sm:gap-5">
                @foreach($monthlyRevenue as $month => $value)
                    @php($height = $value > 0 ? max(8, round(($value / $maxRevenue) * 100)) : 3)
                    <div class="flex h-full min-w-0 flex-col justify-end">
                        <div class="mb-2 hidden truncate text-center text-[10px] font-bold text-zinc-500 sm:block">₱{{ number_format($value,0) }}</div>
                        <div class="group relative flex h-36 items-end overflow-hidden rounded-lg bg-stone-100">
                            <div class="w-full rounded-t-lg bg-zinc-900 transition group-hover:bg-orange-500" style="height: {{ $height }}%"></div>
                        </div>
                        <p class="mt-2 truncate text-center font-mono text-[8px] font-semibold uppercase tracking-wide text-zinc-400">{{ Str::before($month, ' ') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_1fr]">
        <section class="hardware-panel rounded-2xl border border-zinc-200 bg-white">
            <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4">
                <div><p class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-400">Activity</p><h2 class="mt-0.5 font-extrabold">Recent orders</h2></div>
                <a class="text-xs font-bold text-orange-600 hover:text-orange-700" href="{{ route('admin.orders.index') }}">View all →</a>
            </div>
            <div class="divide-y divide-zinc-100 px-5">
                @forelse($recentOrders as $order)
                    <a href="{{ route('admin.orders.show',$order) }}" class="grid gap-2 py-4 sm:grid-cols-[1fr_auto_auto] sm:items-center sm:gap-6">
                        <div><p class="text-sm font-bold text-zinc-900">{{ $order->name }}</p><p class="mt-0.5 font-mono text-[9px] uppercase tracking-wide text-zinc-400">#{{ Str::limit($order->id,8,'') }} · {{ $order->created_at->format('M d, Y') }}</p></div>
                        <span class="w-fit rounded-md px-2 py-1 text-[9px] font-extrabold uppercase tracking-wide {{ $order->status==='complete'?'bg-emerald-50 text-emerald-700':($order->status==='refunded'?'bg-zinc-100 text-zinc-600':'bg-amber-50 text-amber-700') }}">{{ $order->status }}</span>
                        <strong class="text-sm text-zinc-900">₱{{ number_format($order->total/100,2) }}</strong>
                    </a>
                @empty
                    <p class="py-10 text-center text-sm text-zinc-400">No orders yet.</p>
                @endforelse
            </div>
        </section>

        <section class="hardware-panel rounded-2xl border border-zinc-200 bg-white">
            <div class="border-b border-zinc-100 px-5 py-4">
                <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-400">Inventory</p>
                <h2 class="mt-0.5 font-extrabold">Needs attention</h2>
                <p class="mt-1 text-[11px] text-zinc-400">Five units or fewer</p>
            </div>
            <div class="divide-y divide-zinc-100 px-5">
                @forelse($lowStockProducts as $product)
                    <a href="{{ route('admin.product.edit',$product) }}" class="flex items-center gap-3 py-3.5">
                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-xl border border-zinc-200"><x-product-media :product="$product" compact /></div>
                        <div class="min-w-0 flex-1"><p class="truncate text-xs font-bold text-zinc-900">{{ $product->name }}</p><p class="truncate text-[10px] text-zinc-400">{{ $product->category?->name }}</p></div>
                        <span class="rounded-md px-2 py-1 text-[9px] font-extrabold {{ $product->stock===0?'bg-red-50 text-red-600':'bg-amber-50 text-amber-700' }}">{{ $product->stock }} left</span>
                    </a>
                @empty
                    <p class="py-10 text-center text-sm text-zinc-400">Inventory looks healthy.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-admin-layout>
