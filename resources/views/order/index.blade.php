<x-app-layout title="My orders — Boltify" description="Review your Boltify hardware orders and refund status." :noindex="true">
    <header class="border-b border-zinc-300/80 pb-8">
        <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-orange-600">Account / order history</p>
        <h1 class="mt-3 text-4xl font-extrabold tracking-[-0.06em] sm:text-5xl">Orders, without the paperwork.</h1>
        <p class="mt-4 max-w-xl text-sm leading-7 text-zinc-600">A straightforward record of purchases, totals, and current order status.</p>
    </header>

    <section class="py-10">
        <div class="border-y border-zinc-300/80 divide-y divide-zinc-300/80">
            @forelse($orders as $order)
                <a href="{{ route('order.show',$order) }}" class="group grid gap-4 py-6 sm:grid-cols-[1fr_auto_auto] sm:items-center sm:gap-8">
                    <div>
                        <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">{{ $order->created_at->format('M d, Y') }} / {{ $order->products_count }} line{{ $order->products_count === 1 ? '' : 's' }}</p>
                        <p class="mt-2 text-lg font-extrabold tracking-[-0.035em] group-hover:text-orange-600">Order #{{ str($order->id)->substr(0,8) }}</p>
                    </div>
                    <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] {{ $order->status === 'complete' ? 'text-emerald-700' : ($order->status === 'refunded' ? 'text-zinc-500' : 'text-amber-700') }}">{{ ucfirst($order->status) }}</span>
                    <div class="flex items-center gap-5 sm:justify-end">
                        <strong class="text-lg tracking-[-0.03em]">₱{{ number_format($order->total/100,2) }}</strong>
                        <span class="text-zinc-400 transition-transform duration-200 group-hover:translate-x-1 group-hover:text-orange-600">→</span>
                    </div>
                </a>
            @empty
                <div class="py-20 text-center">
                    <p class="font-bold">No orders yet.</p>
                    <a href="{{ route('feed') }}" class="mt-4 inline-flex border-b border-zinc-950 pb-1 text-sm font-bold hover:border-orange-600 hover:text-orange-600">Browse the catalog →</a>
                </div>
            @endforelse
        </div>
    </section>
</x-app-layout>
