@props(['categories','filter','minPrice','maxPrice'])

<form action="{{ route('feed') }}" method="get" class="hardware-panel rounded-2xl border border-zinc-200 bg-white p-4">
    <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
        <div>
            <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-400">Refine catalog</p>
            <h2 class="mt-0.5 text-sm font-bold">Filters</h2>
        </div>
        <a href="{{ route('feed') }}" class="text-[11px] font-bold text-orange-600 hover:text-orange-700">Reset</a>
    </div>

    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif

    <div class="mt-4">
        <p class="mb-3 text-xs font-bold text-zinc-800">Department</p>
        <div class="space-y-2.5">
            @foreach($categories as $category)
                <label class="group flex cursor-pointer items-center gap-2.5 text-xs text-zinc-600">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" @checked(in_array($category->id,$filter??[])) class="h-4 w-4 rounded border-zinc-300 text-orange-500 focus:ring-orange-400">
                    <span class="group-hover:text-zinc-950">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="mt-5 border-t border-zinc-100 pt-4">
        <p class="mb-3 text-xs font-bold text-zinc-800">Price range</p>
        <div class="grid grid-cols-2 gap-2">
            <label>
                <span class="mb-1 block font-mono text-[9px] uppercase tracking-wider text-zinc-400">Minimum</span>
                <div class="relative"><span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-xs text-zinc-400">₱</span><input type="number" name="min_price" min="0" value="{{ $minPrice }}" class="w-full rounded-lg border-zinc-200 py-2 pl-6 pr-2 text-xs"></div>
            </label>
            <label>
                <span class="mb-1 block font-mono text-[9px] uppercase tracking-wider text-zinc-400">Maximum</span>
                <div class="relative"><span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-xs text-zinc-400">₱</span><input type="number" name="max_price" min="0" value="{{ $maxPrice }}" class="w-full rounded-lg border-zinc-200 py-2 pl-6 pr-2 text-xs"></div>
            </label>
        </div>
    </div>

    <button class="mt-5 w-full rounded-xl bg-zinc-950 px-4 py-2.5 text-xs font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950">Apply filters</button>
</form>
