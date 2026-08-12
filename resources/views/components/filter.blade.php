@props(['categories','filter','minPrice','maxPrice'])

<form action="{{ route('feed') }}" method="get" class="border-t border-zinc-400/80 pt-5">
    <div class="flex items-center justify-between">
        <div>
            <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.2em] text-zinc-500">Refine inventory</p>
            <h2 class="mt-1 text-lg font-extrabold tracking-[-0.035em]">Filter</h2>
        </div>
        <a href="{{ route('feed') }}" class="text-[11px] font-semibold text-zinc-500 hover:text-orange-600">Clear</a>
    </div>

    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif

    <div class="mt-7 border-t border-zinc-300/80 pt-5">
        <p class="mb-4 font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Department</p>
        <div class="space-y-3">
            @foreach($categories as $category)
                <label class="group flex cursor-pointer items-center gap-3 text-xs text-zinc-600">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" @checked(in_array($category->id,$filter??[])) class="h-3.5 w-3.5 rounded-none border-zinc-400 bg-transparent text-orange-600 focus:ring-orange-500">
                    <span class="group-hover:text-zinc-950">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="mt-7 border-t border-zinc-300/80 pt-5">
        <p class="mb-4 font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Price range</p>
        <div class="grid grid-cols-2 gap-3">
            <label>
                <span class="mb-1.5 block text-[10px] font-medium text-zinc-500">Minimum</span>
                <div class="flex items-center border-b border-zinc-400"><span class="text-xs text-zinc-400">₱</span><input type="number" name="min_price" min="0" value="{{ $minPrice }}" class="w-full border-0 bg-transparent px-1 py-2 text-xs focus:ring-0"></div>
            </label>
            <label>
                <span class="mb-1.5 block text-[10px] font-medium text-zinc-500">Maximum</span>
                <div class="flex items-center border-b border-zinc-400"><span class="text-xs text-zinc-400">₱</span><input type="number" name="max_price" min="0" value="{{ $maxPrice }}" class="w-full border-0 bg-transparent px-1 py-2 text-xs focus:ring-0"></div>
            </label>
        </div>
    </div>

    <button class="mt-7 flex w-full items-center justify-between border-y border-zinc-950 py-3 text-left text-xs font-extrabold text-zinc-950 hover:text-orange-600">
        <span>Apply filters</span><span aria-hidden="true">→</span>
    </button>
</form>
