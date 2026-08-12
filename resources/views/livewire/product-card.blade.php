<article class="group hardware-panel flex h-full flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white">
    <a href="{{ route('product.show',$product) }}" class="relative block aspect-[4/3] overflow-hidden border-b border-zinc-100 bg-stone-100">
        <x-product-media :product="$product" class="transition duration-500 group-hover:scale-[1.025]" />
        <span class="absolute left-3 top-3 rounded-md border border-white/70 bg-white/90 px-2 py-1 font-mono text-[8px] font-semibold uppercase tracking-[0.14em] text-zinc-600 shadow-sm backdrop-blur">{{ $product->category?->name ?? 'Hardware' }}</span>
    </a>

    <div class="flex flex-1 flex-col p-4">
        <a href="{{ route('product.show',$product) }}" class="line-clamp-2 text-[15px] font-extrabold leading-snug tracking-[-0.025em] text-zinc-900 group-hover:text-orange-600">{{ $product->name }}</a>
        <p class="mt-2 line-clamp-2 text-xs leading-5 text-zinc-500">{{ $product->description }}</p>

        <div class="mt-auto pt-5">
            <div class="mb-3 flex items-end justify-between gap-3">
                <div>
                    <p class="font-mono text-[8px] font-semibold uppercase tracking-[0.14em] text-zinc-400">Unit price</p>
                    <p class="mt-0.5 text-lg font-extrabold tracking-[-0.035em] text-zinc-950">₱{{ number_format($product->price,2) }}</p>
                </div>
                @if($product->stock > 5)
                    <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>{{ $product->stock }} in stock</span>
                @elseif($product->stock > 0)
                    <span class="flex items-center gap-1.5 text-[10px] font-bold text-amber-700"><span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>{{ $product->stock }} left</span>
                @else
                    <span class="flex items-center gap-1.5 text-[10px] font-bold text-red-600"><span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>Out of stock</span>
                @endif
            </div>

            <button wire:click="store" wire:loading.attr="disabled" @disabled($product->stock<1) class="flex w-full items-center justify-center gap-2 rounded-xl bg-zinc-950 px-3 py-2.5 text-xs font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950 disabled:cursor-not-allowed disabled:bg-zinc-200 disabled:text-zinc-400">
                <span wire:loading.remove>Add to cart</span>
                <span wire:loading>Adding…</span>
                <i data-feather="plus" class="h-3.5 w-3.5" wire:loading.remove></i>
            </button>
        </div>
    </div>
</article>
