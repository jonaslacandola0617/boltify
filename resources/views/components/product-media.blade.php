@props(['product', 'compact' => false])

@php
    $images = json_decode($product->images, true) ?: [];
    $category = $product->category?->name ?? 'Hardware';
@endphp

@if($images)
    <img
        src="{{ asset('storage/'.$images[0]) }}"
        alt="{{ $product->name }}"
        {{ $attributes->merge(['class' => 'h-full w-full object-cover']) }}
    >
@else
    <div {{ $attributes->merge(['class' => 'hardware-product-visual relative flex h-full w-full overflow-hidden bg-[#e7e4dd]']) }}>
        <div class="absolute inset-0 hardware-grid opacity-55"></div>
        <div class="absolute -right-12 -top-12 h-40 w-40 border-[28px] border-orange-500/10"></div>
        <div class="absolute bottom-0 left-0 h-1 w-20 bg-orange-500"></div>
        <div class="relative flex h-full w-full flex-col justify-between {{ $compact ? 'p-3' : 'p-5 sm:p-6' }}">
            <div class="flex items-center justify-between gap-3">
                <span class="font-mono text-[8px] font-semibold uppercase tracking-[0.2em] text-zinc-500">Boltify / Supply</span>
                <span class="font-mono text-[8px] font-semibold uppercase tracking-[0.16em] text-zinc-400">No. {{ Str::upper(Str::substr($product->id, 0, 4)) }}</span>
            </div>

            <div class="flex items-end justify-between gap-5">
                <div class="min-w-0">
                    <svg viewBox="0 0 48 48" class="mb-5 h-10 w-10 fill-none stroke-zinc-700" aria-hidden="true">
                        <path d="M16 8h16l8 16-8 16H16L8 24 16 8Z" stroke-width="1.5"/>
                        <circle cx="24" cy="24" r="6" stroke-width="1.5"/>
                    </svg>
                    <p class="truncate font-mono text-[8px] font-bold uppercase tracking-[0.18em] text-orange-700">{{ $category }}</p>
                    @unless($compact)
                        <p class="mt-2 line-clamp-2 max-w-[20rem] text-sm font-bold leading-snug tracking-[-0.025em] text-zinc-800">{{ $product->name }}</p>
                    @endunless
                </div>
                @unless($compact)
                    <span class="shrink-0 font-mono text-[8px] uppercase tracking-[0.16em] text-zinc-400">Catalog visual</span>
                @endunless
            </div>
        </div>
    </div>
@endif
