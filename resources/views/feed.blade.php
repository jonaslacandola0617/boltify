<x-app-layout>
    <section class="hardware-panel overflow-hidden rounded-[1.75rem] border border-zinc-800 bg-zinc-950 text-white">
        <div class="grid lg:grid-cols-[1.35fr_.65fr]">
            <div class="relative overflow-hidden px-6 py-10 sm:px-10 sm:py-14 lg:px-12 lg:py-16">
                <div class="hardware-grid absolute inset-0 opacity-[0.08]"></div>
                <div class="relative max-w-3xl">
                    <div class="flex items-center gap-3">
                        <span class="h-px w-8 bg-orange-500"></span>
                        <span class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-orange-400">Boltify Hardware Supply</span>
                    </div>
                    <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-[1.04] tracking-[-0.055em] sm:text-5xl lg:text-6xl">The hardware store,<br class="hidden sm:block"> built for the screen.</h1>
                    <p class="mt-5 max-w-2xl text-sm leading-7 text-zinc-400 sm:text-base">A focused catalog of tools, fasteners, building supplies, electrical, plumbing, finishing, and jobsite essentials—organized the way real work gets done.</p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="#catalog" class="rounded-xl bg-orange-500 px-5 py-3 text-sm font-extrabold text-zinc-950 hover:bg-orange-400">Browse the catalog</a>
                        @if($categories->firstWhere('name', 'Safety & PPE'))
                            <a href="{{ route('feed', ['categories' => [$categories->firstWhere('name', 'Safety & PPE')->id]]) }}" class="rounded-xl border border-zinc-700 px-5 py-3 text-sm font-semibold text-zinc-200 hover:border-zinc-500 hover:bg-zinc-900">Shop safety gear</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="relative min-h-[280px] overflow-hidden bg-orange-500 p-6 text-zinc-950 sm:p-8 lg:p-10">
                <div class="absolute -bottom-20 -right-16 h-64 w-64 rounded-full border-[42px] border-zinc-950/10"></div>
                <div class="relative flex h-full flex-col justify-between gap-10">
                    <div class="flex items-start justify-between gap-6">
                        <span class="font-mono text-[10px] font-bold uppercase tracking-[0.2em]">Trade counter / 01</span>
                        <svg viewBox="0 0 48 48" class="h-12 w-12 fill-none stroke-zinc-950" aria-hidden="true">
                            <path d="M16 8h16l8 16-8 16H16L8 24 16 8Z" stroke-width="2"/>
                            <circle cx="24" cy="24" r="6" stroke-width="2"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-extrabold tracking-[-0.05em]">{{ $categories->count() }} departments</p>
                        <p class="text-sm font-medium text-zinc-900/70">From the tool bench to finishing work.</p>
                    </div>
                    <div class="grid grid-cols-2 border-t border-zinc-950/20 pt-5 text-xs font-bold">
                        <div><span class="block font-mono text-[9px] uppercase tracking-widest text-zinc-950/50">Inventory</span><span class="mt-1 block">Stock-aware</span></div>
                        <div><span class="block font-mono text-[9px] uppercase tracking-widest text-zinc-950/50">Catalog</span><span class="mt-1 block">Search & filter</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="-mt-2 overflow-x-auto pb-1">
        <div class="flex min-w-max gap-2">
            <a href="{{ route('feed') }}" class="rounded-lg border border-zinc-900 bg-zinc-950 px-3.5 py-2 text-xs font-bold text-white">All departments</a>
            @foreach($categories as $category)
                <a href="{{ route('feed', ['categories' => [$category->id]]) }}" class="rounded-lg border border-zinc-200 bg-white px-3.5 py-2 text-xs font-semibold text-zinc-600 shadow-sm hover:border-zinc-400 hover:text-zinc-950">{{ $category->name }}</a>
            @endforeach
        </div>
    </section>

    <div id="catalog" class="grid scroll-mt-28 gap-7 lg:grid-cols-[250px_1fr]">
        <aside class="lg:sticky lg:top-28 lg:self-start">
            <x-filter :categories="$categories" :filter="$filter" :minPrice="$minPrice" :maxPrice="$maxPrice"/>
        </aside>

        <section class="min-w-0">
            <div class="mb-5 flex flex-col gap-4 border-b border-zinc-200 pb-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.18em] text-orange-600">Current inventory</p>
                    <h2 class="mt-1 text-2xl font-extrabold tracking-[-0.04em]">Hardware catalog</h2>
                    <p class="mt-1 text-sm text-zinc-500">{{ $products->total() }} item{{ $products->total() === 1 ? '' : 's' }}{{ $search ? ' matching “'.$search.'”':'' }}</p>
                </div>
                <form method="get" class="flex items-center gap-2">
                    @foreach(request()->except('sort','page') as $key=>$value)
                        @if(is_array($value))
                            @foreach($value as $v)<input type="hidden" name="{{ $key }}[]" value="{{ $v }}">@endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <label class="font-mono text-[9px] font-semibold uppercase tracking-widest text-zinc-400" for="sort">Sort</label>
                    <select id="sort" name="sort" onchange="this.form.submit()" class="rounded-xl border-zinc-200 bg-white py-2.5 text-sm font-medium shadow-sm">
                        <option value="newest" @selected($sort==='newest')>Newest</option>
                        <option value="price_low" @selected($sort==='price_low')>Price: low to high</option>
                        <option value="price_high" @selected($sort==='price_high')>Price: high to low</option>
                        <option value="name" @selected($sort==='name')>Name</option>
                    </select>
                </form>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                @forelse($products as $product)
                    <livewire:product-card :product="$product" :key="$product->id"/>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-zinc-300 bg-white p-12 text-center">
                        <p class="font-semibold text-zinc-700">No hardware matched that search.</p>
                        <p class="mt-1 text-sm text-zinc-400">Try clearing a filter or searching a broader product name.</p>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div class="mt-8">{{ $products->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
