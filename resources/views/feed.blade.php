<x-app-layout
    :title="$search ? 'Search: '.$search.' — Boltify Hardware' : 'Boltify — Tools, Hardware & Jobsite Essentials'"
    description="Shop tools, hardware supplies, fasteners, electrical, plumbing, safety gear, finishing materials, and jobsite essentials from Boltify."
    :canonical="route('feed')"
    :noindex="request()->query() !== []"
>
    <section class="relative border-b border-zinc-300/80 pb-12 lg:pb-16">
        <div class="grid gap-12 lg:grid-cols-[1.45fr_.55fr] lg:items-end">
            <div>
                <div class="flex items-center gap-3 font-mono text-[10px] font-semibold uppercase tracking-[0.22em] text-zinc-500">
                    <span class="inline-block h-2 w-2 bg-orange-500"></span>
                    Boltify Hardware Supply
                </div>
                <h1 class="mt-7 max-w-5xl text-[clamp(3.5rem,8vw,8rem)] font-extrabold leading-[0.86] tracking-[-0.075em] text-zinc-950">
                    Hardware,<br>
                    <span class="text-orange-600">without the clutter.</span>
                </h1>
                <p class="mt-8 max-w-2xl text-base leading-8 text-zinc-600 sm:text-lg">A modern trade counter for dependable tools, repair essentials, building supplies, and the small things that keep a job moving.</p>
            </div>

            <div class="grid grid-cols-2 gap-x-8 gap-y-8 border-t border-zinc-300/80 pt-6 lg:border-t-0 lg:pt-0">
                <div>
                    <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Departments</p>
                    <p class="mt-2 text-3xl font-extrabold tracking-[-0.05em]">{{ $categories->count() }}</p>
                </div>
                <div>
                    <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Catalog</p>
                    <p class="mt-2 text-3xl font-extrabold tracking-[-0.05em]">{{ $products->total() }}</p>
                </div>
                <div class="col-span-2 border-t border-zinc-300/80 pt-5">
                    <p class="text-sm leading-6 text-zinc-600">Stock-aware shopping, practical categories, and straightforward pricing. Designed around the way a real hardware counter works.</p>
                    <a href="#catalog" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-zinc-950 hover:text-orange-600">Browse inventory <span aria-hidden="true">↓</span></a>
                </div>
            </div>
        </div>
    </section>

    <section id="departments" class="border-b border-zinc-300/80 py-8">
        <div class="mb-5 flex items-baseline justify-between gap-6">
            <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-zinc-500">Shop by department</p>
            <a href="{{ route('feed') }}" class="text-xs font-semibold text-zinc-500 hover:text-orange-600">View everything</a>
        </div>
        <div class="flex flex-wrap gap-x-7 gap-y-3">
            @foreach($categories as $category)
                <a href="{{ route('feed', ['categories' => [$category->id]]) }}" class="group inline-flex items-center gap-2 text-lg font-bold tracking-[-0.03em] text-zinc-800 hover:text-orange-600">
                    {{ $category->name }}
                    <span class="text-sm font-normal text-zinc-300 transition-transform duration-200 group-hover:translate-x-1 group-hover:text-orange-400">↗</span>
                </a>
            @endforeach
        </div>
    </section>

    <div id="catalog" class="grid scroll-mt-28 gap-10 py-10 lg:grid-cols-[220px_1fr] lg:gap-14 lg:py-14">
        <aside class="lg:sticky lg:top-28 lg:self-start">
            <x-filter :categories="$categories" :filter="$filter" :minPrice="$minPrice" :maxPrice="$maxPrice"/>
        </aside>

        <section class="min-w-0">
            <div class="mb-8 flex flex-col gap-5 border-b border-zinc-300/80 pb-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-orange-600">Inventory / live catalog</p>
                    <h2 class="mt-2 text-3xl font-extrabold tracking-[-0.055em] sm:text-4xl">Tools for the work ahead.</h2>
                    <p class="mt-2 text-sm text-zinc-500">{{ $products->total() }} item{{ $products->total() === 1 ? '' : 's' }}{{ $search ? ' matching “'.$search.'”':'' }}</p>
                </div>
                <form method="get" class="flex items-center gap-3">
                    @foreach(request()->except('sort','page') as $key=>$value)
                        @if(is_array($value))
                            @foreach($value as $v)<input type="hidden" name="{{ $key }}[]" value="{{ $v }}">@endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <label class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500" for="sort">Sort</label>
                    <select id="sort" name="sort" onchange="this.form.submit()" class="border-0 border-b border-zinc-400 bg-transparent py-2 pl-0 pr-8 text-sm font-semibold focus:border-zinc-950 focus:ring-0">
                        <option value="newest" @selected($sort==='newest')>Newest</option>
                        <option value="price_low" @selected($sort==='price_low')>Price: low to high</option>
                        <option value="price_high" @selected($sort==='price_high')>Price: high to low</option>
                        <option value="name" @selected($sort==='name')>Name</option>
                    </select>
                </form>
            </div>

            <div class="grid gap-x-5 gap-y-12 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                @forelse($products as $product)
                    <livewire:product-card :product="$product" :key="$product->id"/>
                @empty
                    <div class="col-span-full border-y border-dashed border-zinc-300 py-16 text-center">
                        <p class="font-semibold text-zinc-800">No hardware matched that search.</p>
                        <p class="mt-2 text-sm text-zinc-500">Try clearing a filter or searching a broader product name.</p>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div class="mt-14 border-t border-zinc-300/80 pt-7">{{ $products->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
