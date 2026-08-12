<article class="group flex h-full flex-col">
    <a href="{{ route('product.show',$product) }}" class="relative block aspect-[5/4] overflow-hidden bg-[#e9e6df]">
        <x-product-media :product="$product" class="transition duration-700 ease-out group-hover:scale-[1.035]" />
        <span class="absolute left-0 top-0 bg-[#f4f2ed]/92 px-2.5 py-1.5 font-mono text-[8px] font-semibold uppercase tracking-[0.16em] text-zinc-600 backdrop-blur-sm">{{ $product->category?->name ?? 'Hardware' }}</span>
        @if($product->stock < 1)
            <span class="absolute bottom-0 right-0 bg-zinc-950 px-2.5 py-1.5 font-mono text-[8px] font-semibold uppercase tracking-[0.16em] text-white">Out of stock</span>
        @endif
    </a>

    <div class="flex flex-1 flex-col border-t border-zinc-300/70 pt-4">
        <div class="flex items-start justify-between gap-4">
            <a href="{{ route('product.show',$product) }}" class="max-w-[80%] text-[15px] font-bold leading-snug tracking-[-0.035em] text-zinc-950 group-hover:text-orange-600">{{ $product->name }}</a>
            <span class="shrink-0 text-sm font-extrabold tracking-[-0.03em] text-zinc-950">₱{{ number_format($product->price,2) }}</span>
        </div>
        <p class="mt-2 line-clamp-2 text-xs leading-5 text-zinc-500">{{ $product->description }}</p>

        <div class="mt-auto flex items-end justify-between gap-4 pt-5">
            <div class="font-mono text-[8px] font-semibold uppercase tracking-[0.16em]">
                @if($product->stock > 5)
                    <span class="text-emerald-700">{{ $product->stock }} available</span>
                @elseif($product->stock > 0)
                    <span class="text-amber-700">Only {{ $product->stock }} left</span>
                @else
                    <span class="text-red-600">Unavailable</span>
                @endif
            </div>

            <button wire:click="store" wire:loading.attr="disabled" @disabled($product->stock<1) class="group/button inline-flex items-center gap-2 border-b border-zinc-950 pb-1 text-xs font-extrabold text-zinc-950 hover:border-orange-600 hover:text-orange-600 disabled:border-zinc-300 disabled:text-zinc-400">
                <span wire:loading.remove>Add to cart</span>
                <span wire:loading>Adding…</span>
                <span wire:loading.remove aria-hidden="true" class="transition-transform duration-200 group-hover/button:translate-x-1">→</span>
            </button>
        </div>
    </div>
</article>
