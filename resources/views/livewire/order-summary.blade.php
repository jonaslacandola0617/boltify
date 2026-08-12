<aside class="h-fit border-t border-zinc-950 pt-5 lg:sticky lg:top-28">
    <div class="flex items-baseline justify-between gap-4">
        <h2 class="text-lg font-extrabold tracking-[-0.035em]">Order summary</h2>
        <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">{{ $count }} item{{ $count === 1 ? '' : 's' }}</span>
    </div>

    <div class="mt-6 space-y-4">
        @foreach($summary as $item)
            <div class="flex justify-between gap-5 text-sm">
                <div class="min-w-0">
                    <p class="truncate font-semibold">{{ $item['name'] }}</p>
                    <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.12em] text-zinc-500">{{ $item['quantity'] }} × ₱{{ number_format($item['price'],2) }}</p>
                </div>
                <span class="shrink-0 font-semibold">₱{{ number_format($item['totalPrice'],2) }}</span>
            </div>
        @endforeach
    </div>

    <div class="mt-7 border-y border-zinc-300/80 py-5">
        <div class="flex items-end justify-between gap-5">
            <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Subtotal</span>
            <strong class="text-2xl tracking-[-0.045em]">₱{{ number_format($subTotal,2) }}</strong>
        </div>
    </div>

    <a href="{{ route('checkout.index') }}" class="mt-5 flex w-full items-center justify-between bg-zinc-950 px-5 py-4 text-sm font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950">
        <span>Continue to checkout</span><span aria-hidden="true">→</span>
    </a>
</aside>
