@php($images=json_decode($product->images,true)?:[])

<div>
    <nav class="mb-8 flex min-w-0 items-center gap-2 font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500" aria-label="Breadcrumb">
        <a href="{{ route('feed') }}" class="hover:text-orange-600">Catalog</a>
        <span class="text-zinc-300">/</span>
        <a href="{{ route('feed', ['categories' => $product->categoryId ? [$product->categoryId] : []]) }}" class="hover:text-orange-600">{{ $product->category?->name ?? 'Hardware' }}</a>
        <span class="text-zinc-300">/</span>
        <span class="truncate text-zinc-700">{{ $product->name }}</span>
    </nav>

    <div class="grid gap-10 lg:grid-cols-[1.12fr_.88fr] lg:gap-16 xl:gap-24">
        <div @if($images) x-data="{active:0}" @endif class="space-y-3">
            <div class="aspect-[5/4] overflow-hidden bg-[#e7e4dd] lg:aspect-square">
                @if($images)
                    @foreach($images as $i=>$img)
                        <img x-show="active==={{ $i }}" src="{{ asset('storage/'.$img) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    @endforeach
                @else
                    <x-product-media :product="$product" />
                @endif
            </div>

            @if(count($images)>1)
                <div class="grid grid-cols-5 gap-2 border-t border-zinc-300/80 pt-3">
                    @foreach($images as $i=>$img)
                        <button @click="active={{ $i }}" class="aspect-square overflow-hidden border-b-2 border-transparent bg-[#e7e4dd] p-0 hover:border-orange-500">
                            <img src="{{ asset('storage/'.$img) }}" alt="{{ $product->name }} thumbnail {{ $i + 1 }}" class="h-full w-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex flex-col lg:pt-5">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-orange-600">{{ $product->category?->name ?? 'Hardware' }}</span>
                <span class="h-3 w-px bg-zinc-300"></span>
                @if($product->stock > 5)
                    <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-emerald-700">In stock / {{ $product->stock }}</span>
                @elseif($product->stock > 0)
                    <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-amber-700">Low stock / {{ $product->stock }}</span>
                @else
                    <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-red-600">Out of stock</span>
                @endif
            </div>

            <h1 class="mt-5 max-w-3xl text-4xl font-extrabold leading-[0.98] tracking-[-0.065em] text-zinc-950 sm:text-5xl xl:text-6xl">{{ $product->name }}</h1>
            <p class="mt-7 text-3xl font-extrabold tracking-[-0.05em] text-zinc-950 sm:text-4xl">₱{{ number_format($product->price,2) }}</p>
            <p class="mt-8 max-w-xl text-sm leading-7 text-zinc-600 sm:text-base sm:leading-8">{{ $product->description }}</p>

            <dl class="mt-10 border-y border-zinc-300/80">
                <div class="grid grid-cols-[120px_1fr] gap-4 border-b border-zinc-300/80 py-4 text-xs">
                    <dt class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Department</dt>
                    <dd class="font-semibold text-zinc-900">{{ $product->category?->name ?? 'Hardware' }}</dd>
                </div>
                <div class="grid grid-cols-[120px_1fr] gap-4 border-b border-zinc-300/80 py-4 text-xs">
                    <dt class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Availability</dt>
                    <dd class="font-semibold text-zinc-900">{{ $product->stock }} unit{{ $product->stock === 1 ? '' : 's' }} available</dd>
                </div>
                <div class="grid grid-cols-[120px_1fr] gap-4 py-4 text-xs">
                    <dt class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Supply type</dt>
                    <dd class="font-semibold text-zinc-900">Hardware / trade supply</dd>
                </div>
            </dl>

            <div class="mt-9 flex flex-wrap items-center gap-5">
                <div class="flex items-center border-y border-zinc-400">
                    <button wire:click="decrement" class="flex h-12 w-12 items-center justify-center text-lg font-semibold hover:text-orange-600" aria-label="Decrease quantity">−</button>
                    <span class="min-w-12 border-x border-zinc-300 text-center text-sm font-extrabold">{{ $quantity }}</span>
                    <button wire:click="increment" class="flex h-12 w-12 items-center justify-center text-lg font-semibold hover:text-orange-600" aria-label="Increase quantity">+</button>
                </div>
                <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Select quantity</span>
            </div>

            <button wire:click="addToCart" wire:loading.attr="disabled" @disabled($product->stock<1) class="mt-5 flex w-full items-center justify-between bg-zinc-950 px-5 py-4 text-sm font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950 disabled:bg-zinc-300 disabled:text-zinc-500 sm:max-w-sm">
                <span wire:loading.remove>{{ $product->stock>0?'Add to cart':'Out of stock' }}</span>
                <span wire:loading>Adding to cart…</span>
                <span wire:loading.remove aria-hidden="true">→</span>
            </button>
        </div>
    </div>
</div>
