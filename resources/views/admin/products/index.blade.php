<x-admin-layout>
<div x-data="{createOpen:{{ $errors->any() ? 'true':'false' }}}" class="flex flex-col gap-6">
    <div class="flex flex-col gap-3 border-b border-zinc-200 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-orange-600">Inventory / Catalog</p>
            <h1 class="mt-1 text-3xl font-extrabold tracking-[-0.05em] text-zinc-950">Products</h1>
            <p class="mt-1 text-sm text-zinc-500">Manage pricing, stock, product media, and departments.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.categories.index') }}" class="rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-bold shadow-sm hover:border-zinc-400">Categories</a>
            <button @click="createOpen=true" class="rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950">Add product</button>
        </div>
    </div>

    <form method="get" class="hardware-panel grid gap-3 rounded-2xl border border-zinc-200 bg-white p-4 sm:grid-cols-4">
        <div class="relative"><i data-feather="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400"></i><input name="search" value="{{ $search }}" placeholder="Search products" class="w-full rounded-xl border-zinc-200 py-2.5 pl-9 text-sm"></div>
        <select name="category" class="rounded-xl border-zinc-200 text-sm"><option value="">All departments</option>@foreach($categories as $c)<option value="{{ $c->id }}" @selected($category===$c->id)>{{ $c->name }}</option>@endforeach</select>
        <select name="stock" class="rounded-xl border-zinc-200 text-sm"><option value="">All inventory</option><option value="available" @selected($stock==='available')>Available</option><option value="low" @selected($stock==='low')>Low stock</option><option value="out" @selected($stock==='out')>Out of stock</option></select>
        <button class="rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-bold text-white hover:bg-orange-500 hover:text-zinc-950">Apply filters</button>
    </form>

    <section class="hardware-panel overflow-hidden rounded-2xl border border-zinc-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] text-left">
                <thead class="border-b border-zinc-100 bg-stone-50/70 font-mono text-[9px] uppercase tracking-[0.12em] text-zinc-400">
                    <tr><th class="px-5 py-3.5">Product</th><th>Department</th><th>Unit price</th><th>Inventory</th><th class="px-5 text-right">Actions</th></tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-stone-50/60">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 shrink-0 overflow-hidden rounded-xl border border-zinc-200 bg-stone-100"><x-product-media :product="$product" compact /></div>
                                    <div class="min-w-0"><p class="truncate text-sm font-bold text-zinc-900">{{ $product->name }}</p><p class="mt-0.5 max-w-md truncate text-[11px] text-zinc-400">{{ $product->description }}</p></div>
                                </div>
                            </td>
                            <td class="text-xs font-medium text-zinc-600">{{ $product->category?->name }}</td>
                            <td class="text-sm font-extrabold text-zinc-900">₱{{ number_format($product->price,2) }}</td>
                            <td>
                                @if($product->stock===0)<span class="rounded-md bg-red-50 px-2 py-1 text-[10px] font-extrabold text-red-600">Out</span>
                                @elseif($product->stock<=5)<span class="rounded-md bg-amber-50 px-2 py-1 text-[10px] font-extrabold text-amber-700">{{ $product->stock }} low</span>
                                @else<span class="rounded-md bg-emerald-50 px-2 py-1 text-[10px] font-extrabold text-emerald-700">{{ $product->stock }} units</span>@endif
                            </td>
                            <td class="px-5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.product.edit',$product) }}" class="rounded-lg border border-zinc-200 px-3 py-2 text-xs font-bold hover:border-zinc-400">Edit</a>
                                    <form method="post" action="{{ route('admin.product.delete',$product) }}">@csrf @method('DELETE')<button class="rounded-lg border border-zinc-200 px-3 py-2 text-xs font-bold text-red-600 hover:border-red-200 hover:bg-red-50">Delete</button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-sm text-zinc-400">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())<div class="border-t border-zinc-100 px-5 py-4">{{ $products->links() }}</div>@endif
    </section>

    <div x-cloak x-show="createOpen" x-transition.opacity class="fixed inset-0 z-[80] flex items-center justify-center bg-zinc-950/60 p-4 backdrop-blur-sm">
        <form @click.outside="createOpen=false" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data" class="grid max-h-[90vh] w-full max-w-2xl gap-4 overflow-y-auto rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xl sm:grid-cols-2">
            @csrf
            <div class="sm:col-span-2"><p class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-orange-600">New catalog item</p><h2 class="mt-1 text-xl font-extrabold">Add product</h2><p class="mt-1 text-xs text-zinc-400">Photos are optional; Boltify will use the catalog artwork when none are uploaded.</p></div>
            <input name="name" value="{{ old('name') }}" required placeholder="Product name" class="rounded-xl border-zinc-200 sm:col-span-2">
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required placeholder="Price" class="rounded-xl border-zinc-200">
            <input type="number" min="0" name="stock" value="{{ old('stock',0) }}" required placeholder="Stock" class="rounded-xl border-zinc-200">
            <select name="category" required class="rounded-xl border-zinc-200 sm:col-span-2"><option value="">Select department</option>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select>
            <textarea name="description" rows="5" required placeholder="Description" class="rounded-xl border-zinc-200 sm:col-span-2">{{ old('description') }}</textarea>
            <label class="rounded-xl border border-dashed border-zinc-300 bg-stone-50 p-4 sm:col-span-2"><span class="block text-xs font-bold text-zinc-700">Product photos</span><span class="mt-1 block text-[10px] text-zinc-400">Optional · JPG, PNG, WEBP · up to 6 files</span><input type="file" name="images[]" accept=".jpg,.jpeg,.png,.webp" multiple class="mt-3 w-full text-xs"></label>
            <div class="flex justify-end gap-2 border-t border-zinc-100 pt-4 sm:col-span-2"><button type="button" @click="createOpen=false" class="rounded-xl border border-zinc-200 px-4 py-2 text-sm font-bold">Cancel</button><button class="rounded-xl bg-zinc-950 px-4 py-2 text-sm font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950">Create product</button></div>
        </form>
    </div>
</div>
</x-admin-layout>
