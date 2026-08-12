@props(['product'])
@php($imgs=json_decode($product->images,true)?:[])

<article class="grid gap-5 py-6 sm:grid-cols-[120px_1fr] sm:gap-6">
    <a href="{{ route('product.show', $product) }}" class="block aspect-square overflow-hidden bg-[#e7e4dd] sm:h-[120px] sm:w-[120px]">
        <x-product-media :product="$product" compact />
    </a>

    <div class="min-w-0">
        <div class="flex items-start justify-between gap-5">
            <div>
                <p class="font-mono text-[8px] font-semibold uppercase tracking-[0.18em] text-orange-600">{{ $product->category?->name ?? 'Hardware' }}</p>
                <a href="{{ route('product.show', $product) }}" class="mt-1 block text-base font-extrabold tracking-[-0.035em] hover:text-orange-600">{{ $product->name }}</a>
            </div>
            <form action="{{ route('cart.update',Auth::user()->cart) }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="productId" value="{{ $product->id }}">
                <button class="flex h-8 w-8 items-center justify-center text-zinc-400 hover:text-red-600" aria-label="Remove {{ $product->name }} from cart"><i data-feather="x" class="h-4 w-4"></i></button>
            </form>
        </div>

        <p class="mt-2 line-clamp-2 max-w-2xl text-xs leading-5 text-zinc-500">{{ $product->description }}</p>

        <div class="mt-5 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="font-mono text-[8px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Unit price</p>
                <strong class="mt-1 block text-lg tracking-[-0.035em]">₱{{ number_format($product->price,2) }}</strong>
            </div>
            <livewire:quantity :quantity="$product->pivot->quantity" :product="$product->id" :key="'qty-'.$product->id"/>
        </div>
    </div>
</article>
