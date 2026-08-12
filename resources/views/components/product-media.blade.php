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
    <div {{ $attributes->merge(['class' => 'hardware-product-visual relative flex h-full w-full overflow-hidden bg-stone-100']) }}>
        <div class="absolute inset-0 hardware-grid opacity-45"></div>
        <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full border-[18px] border-orange-500/10"></div>
        <div class="relative flex h-full w-full flex-col justify-between {{ $compact ? 'p-2.5' : 'p-5' }}">
            <div class="flex items-center justify-between gap-3">
                <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Boltify / Supply</span>
                <span class="h-2 w-2 rounded-full bg-orange-500"></span>
            </div>

            <div class="flex items-end justify-between gap-4">
                <div class="min-w-0">
                    @unless($compact)
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl border border-zinc-300/80 bg-white/80 shadow-sm">
                            <svg viewBox="0 0 48 48" class="h-7 w-7 fill-none stroke-zinc-800" aria-hidden="true">
                                <path d="M16 8h16l8 16-8 16H16L8 24 16 8Z" stroke-width="2.5"/>
                                <circle cx="24" cy="24" r="6" stroke-width="2.5"/>
                            </svg>
                        </div>
                    @endunless
                    <p class="truncate text-[10px] font-bold uppercase tracking-[0.14em] text-orange-600">{{ $category }}</p>
                    @unless($compact)
                        <p class="mt-1 line-clamp-2 max-w-[16rem] text-sm font-semibold leading-snug text-zinc-800">{{ $product->name }}</p>
                    @endunless
                </div>
                @unless($compact)
                    <span class="shrink-0 font-mono text-[9px] text-zinc-400">NO PHOTO</span>
                @endunless
            </div>
        </div>
    </div>
@endif
