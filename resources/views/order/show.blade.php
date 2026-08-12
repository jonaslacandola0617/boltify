<x-app-layout :title="'Order #'.str($order->id)->substr(0,8).' — Boltify'" description="Review your Boltify hardware order details." :noindex="true">
    <header class="border-b border-zinc-300/80 pb-8">
        <a href="{{ route('order.index') }}" class="inline-flex border-b border-zinc-950 pb-1 text-xs font-bold hover:border-orange-600 hover:text-orange-600">← Back to orders</a>
        <div class="mt-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-orange-600">Order record / {{ $order->created_at->format('M d, Y') }}</p>
                <h1 class="mt-3 text-4xl font-extrabold tracking-[-0.06em] sm:text-5xl">#{{ str($order->id)->substr(0,8) }}</h1>
            </div>
            <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Placed {{ $order->created_at->format('M d, Y · h:i A') }}</p>
        </div>
    </header>

    <div class="grid gap-12 py-10 lg:grid-cols-[1fr_360px] lg:gap-16">
        <section>
            <div class="flex items-baseline justify-between gap-4 border-t border-zinc-950 pt-5">
                <h2 class="text-lg font-extrabold tracking-[-0.035em]">Order contents</h2>
                <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">{{ $order->products->count() }} line{{ $order->products->count() === 1 ? '' : 's' }}</span>
            </div>
            <div class="mt-6 divide-y divide-zinc-300/80 border-y border-zinc-300/80">
                @foreach($order->products as $product)
                    @php($unitPrice=$product->pivot->unit_price??$product->price)
                    <div class="grid gap-5 py-5 sm:grid-cols-[88px_1fr_auto] sm:items-center">
                        <a href="{{ route('product.show', $product) }}" class="block aspect-square overflow-hidden bg-[#e7e4dd] sm:h-[88px] sm:w-[88px]">
                            <x-product-media :product="$product" compact />
                        </a>
                        <div class="min-w-0">
                            <p class="font-mono text-[8px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Qty {{ $product->pivot->quantity }} / ₱{{ number_format($unitPrice,2) }} each</p>
                            <a href="{{ route('product.show', $product) }}" class="mt-1 block font-bold tracking-[-0.025em] hover:text-orange-600">{{ $product->name }}</a>
                        </div>
                        <strong class="text-lg tracking-[-0.03em]">₱{{ number_format($unitPrice*$product->pivot->quantity,2) }}</strong>
                    </div>
                @endforeach
            </div>
        </section>

        <aside class="space-y-8">
            <section class="border-t border-zinc-950 pt-5">
                <h2 class="text-lg font-extrabold tracking-[-0.035em]">Summary</h2>
                <dl class="mt-6 border-y border-zinc-300/80">
                    <div class="flex items-center justify-between gap-5 border-b border-zinc-300/80 py-4 text-sm"><dt class="text-zinc-500">Status</dt><dd class="font-bold">{{ ucfirst($order->status) }}</dd></div>
                    <div class="flex items-end justify-between gap-5 py-5"><dt class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Total</dt><dd class="text-3xl font-extrabold tracking-[-0.05em]">₱{{ number_format($order->total/100,2) }}</dd></div>
                </dl>
            </section>

            @if($order->status==='complete'&&!$order->refund)
                <form method="post" action="{{ route('order.cancel',$order) }}" class="border-t border-red-300 pt-5">
                    @csrf
                    <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-red-700">Refund</p>
                    <h2 class="mt-2 font-extrabold text-red-950">Need to reverse this order?</h2>
                    <p class="mt-2 text-xs leading-5 text-red-800/70">This submits a refund request through Stripe.</p>
                    <button class="mt-5 flex w-full items-center justify-between border-y border-red-700 px-4 py-3 text-sm font-bold text-red-800 hover:bg-red-700 hover:text-white"><span>Request refund</span><span>→</span></button>
                </form>
            @endif
        </aside>
    </div>
</x-app-layout>
