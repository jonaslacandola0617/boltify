<x-app-layout>
    <livewire:product-detail :product="$product"/>

    <section class="mt-8 border-t border-zinc-200 pt-8">
        <div class="mb-5 flex items-end justify-between gap-4">
            <div>
                <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.18em] text-orange-600">Same department</p>
                <h2 class="mt-1 text-2xl font-extrabold tracking-[-0.04em]">More for the job</h2>
            </div>
            <a href="{{ route('feed', ['categories' => $product->categoryId ? [$product->categoryId] : []]) }}" class="hidden text-xs font-bold text-zinc-500 hover:text-orange-600 sm:block">View department →</a>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($relatedProducts as $related)
                <livewire:product-card :product="$related" :key="$related->id"/>
            @empty
                <p class="col-span-full rounded-xl border border-dashed border-zinc-300 bg-white p-8 text-center text-sm text-zinc-400">No related products yet.</p>
            @endforelse
        </div>
    </section>
</x-app-layout>
