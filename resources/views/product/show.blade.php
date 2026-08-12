@php
    $images = json_decode($product->images, true) ?: [];
    $productUrl = route('product.show', $product);
    $productDescription = Str::limit(strip_tags($product->description), 155);
    $productImage = $images ? asset('storage/'.$images[0]) : null;
    $productSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'description' => $productDescription,
        'sku' => (string) $product->id,
        'category' => $product->category?->name ?? 'Hardware',
        'url' => $productUrl,
        'offers' => [
            '@type' => 'Offer',
            'url' => $productUrl,
            'priceCurrency' => 'PHP',
            'price' => number_format((float) $product->price, 2, '.', ''),
            'availability' => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'itemCondition' => 'https://schema.org/NewCondition',
        ],
    ];
    if ($images) {
        $productSchema['image'] = collect($images)->map(fn ($image) => asset('storage/'.$image))->values()->all();
    }
    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Catalog', 'item' => route('feed')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $product->category?->name ?? 'Hardware', 'item' => route('feed', ['categories' => [$product->categoryId]])],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $product->name, 'item' => $productUrl],
        ],
    ];
@endphp

<x-app-layout
    :title="$product->name.' — Boltify Hardware'"
    :description="$productDescription"
    :canonical="$productUrl"
    :image="$productImage"
    :json-ld="[$productSchema, $breadcrumbSchema]"
>
    <livewire:product-detail :product="$product"/>

    <section class="mt-16 border-t border-zinc-300/80 pt-9 lg:mt-24 lg:pt-12">
        <div class="mb-9 flex items-end justify-between gap-4">
            <div>
                <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-orange-600">Same department</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-[-0.055em] sm:text-4xl">More for the job.</h2>
            </div>
            <a href="{{ route('feed', ['categories' => $product->categoryId ? [$product->categoryId] : []]) }}" class="hidden border-b border-zinc-950 pb-1 text-xs font-bold hover:border-orange-600 hover:text-orange-600 sm:block">View department →</a>
        </div>
        <div class="grid gap-x-5 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($relatedProducts as $related)
                <livewire:product-card :product="$related" :key="$related->id"/>
            @empty
                <p class="col-span-full border-y border-dashed border-zinc-300 py-12 text-center text-sm text-zinc-500">No related products yet.</p>
            @endforelse
        </div>
    </section>
</x-app-layout>
