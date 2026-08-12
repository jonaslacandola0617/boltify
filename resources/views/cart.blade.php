<x-app-layout title="Shopping cart — Boltify" description="Review the hardware and supplies in your Boltify cart." :noindex="true">
    <header class="border-b border-zinc-300/80 pb-8">
        <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-orange-600">Your cart / {{ $products->count() }} line{{ $products->count() === 1 ? '' : 's' }}</p>
        <h1 class="mt-3 text-4xl font-extrabold tracking-[-0.06em] sm:text-5xl">Ready for the counter.</h1>
        <p class="mt-4 max-w-xl text-sm leading-7 text-zinc-600">Adjust quantities, remove anything you no longer need, then continue to secure checkout.</p>
    </header>

    @if($products->count())
        <div class="grid gap-12 py-10 lg:grid-cols-[1fr_360px] lg:gap-16">
            <section class="divide-y divide-zinc-300/80 border-y border-zinc-300/80">
                @foreach($products as $product)
                    <x-cart-card :product="$product"/>
                @endforeach
            </section>
            <livewire:order-summary/>
        </div>
    @else
        <div class="py-20 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center border border-zinc-400"><i data-feather="shopping-bag" class="h-5 w-5 stroke-zinc-500"></i></div>
            <p class="mt-6 text-lg font-bold tracking-[-0.03em]">Your cart is empty.</p>
            <p class="mt-2 text-sm text-zinc-500">The catalog is ready when you are.</p>
            <a href="{{ route('feed') }}" class="mt-7 inline-flex items-center gap-2 border-b border-zinc-950 pb-1 text-sm font-bold hover:border-orange-600 hover:text-orange-600">Continue shopping →</a>
        </div>
    @endif
</x-app-layout>
