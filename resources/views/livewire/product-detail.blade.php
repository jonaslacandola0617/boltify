@php($images=json_decode($product->images,true)?:[])

<div>
    <nav class="mb-5 flex items-center gap-2 font-mono text-[9px] font-semibold uppercase tracking-[0.14em] text-zinc-400" aria-label="Breadcrumb">
        <a href="{{ route('feed') }}" class="hover:text-orange-600">Catalog</a>
        <span>/</span>
        <span>{{ $product->category?->name ?? 'Hardware' }}</span>
        <span>/</span>
        <span class="truncate text-zinc-600">{{ $product->name }}</span>
    </nav>

    <div class="grid gap-8 lg:grid-cols-[1.08fr_.92fr] lg:gap-12">
        <div @if($images) x-data="{active:0}" @endif class="space-y-3">
            <div class="hardware-panel aspect-square overflow-hidden rounded-[1.75rem] border border-zinc-200 bg-white">
                @if($images)
                    @foreach($images as $i=>$img)
                        <img x-show="active==={{ $i }}" src="{{ asset('storage/'.$img) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    @endforeach
                @else
                    <x-product-media :product="$product" />
                @endif
            </div>

            @if(count($images)>1)
                <div class="grid grid-cols-5 gap-2">
                    @foreach($images as $i=>$img)
                        <button @click="active={{ $i }}" class="aspect-square overflow-hidden rounded-xl border border-zinc-200 bg-white p-0.5 hover:border-zinc-400">
                            <img src="{{ asset('storage/'.$img) }}" alt="{{ $product->name }} thumbnail {{ $i + 1 }}" class="h-full w-full rounded-[0.6rem] object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex flex-col justify-center lg:py-4">
            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-md bg-orange-100 px-2 py-1 font-mono text-[9px] font-bold uppercase tracking-[0.14em] text-orange-700">{{ $product->category?->name ?? 'Hardware' }}</span>
                @if($product->stock > 5)
                    <span class="flex items-center gap-1.5 text-[11px] font-bold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>In stock</span>
                @elseif($product->stock > 0)
                    <span class="flex items-center gap-1.5 text-[11px] font-bold text-amber-700"><span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>Low stock</span>
                @else
                    <span class="flex items-center gap-1.5 text-[11px] font-bold text-red-600"><span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>Out of stock</span>
                @endif
            </div>

            <h1 class="mt-4 max-w-2xl text-3xl font-extrabold leading-[1.08] tracking-[-0.055em] text-zinc-950 sm:text-4xl lg:text-5xl">{{ $product->name }}</h1>
            <p class="mt-5 text-3xl font-extrabold tracking-[-0.045em] text-zinc-950">₱{{ number_format($product->price,2) }}</p>
            <p class="mt-5 max-w-xl text-sm leading-7 text-zinc-600">{{ $product->description }}</p>

            <div class="mt-7 grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-zinc-200 bg-zinc-200 sm:grid-cols-3">
                <div class="bg-white p-3.5"><p class="font-mono text-[8px] font-semibold uppercase tracking-widest text-zinc-400">Department</p><p class="mt-1 text-xs font-bold text-zinc-800">{{ $product->category?->name ?? 'Hardware' }}</p></div>
                <div class="bg-white p-3.5"><p class="font-mono text-[8px] font-semibold uppercase tracking-widest text-zinc-400">Availability</p><p class="mt-1 text-xs font-bold text-zinc-800">{{ $product->stock }} units</p></div>
                <div class="col-span-2 bg-white p-3.5 sm:col-span-1"><p class="font-mono text-[8px] font-semibold uppercase tracking-widest text-zinc-400">Store type</p><p class="mt-1 text-xs font-bold text-zinc-800">Hardware supply</p></div>
            </div>

            <div class="mt-7 flex items-center gap-3">
                <div class="flex items-center overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">
                    <button wire:click="decrement" class="flex h-11 w-11 items-center justify-center text-lg font-semibold hover:bg-zinc-50" aria-label="Decrease quantity">−</button>
                    <span class="min-w-11 border-x border-zinc-100 text-center text-sm font-extrabold">{{ $quantity }}</span>
                    <button wire:click="increment" class="flex h-11 w-11 items-center justify-center text-lg font-semibold hover:bg-zinc-50" aria-label="Increase quantity">+</button>
                </div>
                <span class="text-xs font-medium text-zinc-400">{{ $product->stock }} available</span>
            </div>

            <button wire:click="addToCart" wire:loading.attr="disabled" @disabled($product->stock<1) class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-zinc-950 px-5 py-3.5 text-sm font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950 disabled:bg-zinc-200 disabled:text-zinc-400 sm:w-auto sm:min-w-64">
                <span wire:loading.remove>{{ $product->stock>0?'Add to cart':'Out of stock' }}</span>
                <span wire:loading>Adding to cart…</span>
                <i data-feather="shopping-bag" class="h-4 w-4" wire:loading.remove></i>
            </button>
        </div>
    </div>
</div>
