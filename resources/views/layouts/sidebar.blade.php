<div x-cloak x-show="sidebarOpen" @click="sidebarOpen=false" class="fixed inset-0 z-40 bg-zinc-950/60 backdrop-blur-sm lg:hidden"></div>

<aside class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-zinc-800 bg-zinc-950 p-4 text-white transition-transform lg:sticky lg:top-0 lg:h-screen lg:w-auto lg:translate-x-0" :class="{'translate-x-0':sidebarOpen}">
    <div class="flex items-center justify-between px-2 py-2">
        <a href="{{ route('admin.overview') }}" class="flex items-center gap-2.5">
            <x-application-logo class="text-2xl text-white"/>
            <span class="rounded-md border border-orange-500/30 bg-orange-500/10 px-2 py-1 font-mono text-[8px] font-bold uppercase tracking-[0.14em] text-orange-400">Admin</span>
        </a>
        <button @click="sidebarOpen=false" class="rounded-lg p-2 text-zinc-400 hover:bg-zinc-900 hover:text-white lg:hidden"><i data-feather="x" class="h-5 w-5"></i></button>
    </div>

    <div class="mt-7 rounded-2xl border border-zinc-800 bg-zinc-900/60 p-3">
        <p class="font-mono text-[8px] font-semibold uppercase tracking-[0.18em] text-zinc-600">Store workspace</p>
        <div class="mt-2 flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
            <p class="text-xs font-semibold text-zinc-300">Catalog operations</p>
        </div>
    </div>

    <nav class="mt-6 flex flex-1 flex-col gap-1">
        <p class="mb-2 px-3 font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-600">Workspace</p>
        <x-nav-link href="{{ route('admin.overview') }}" :active="request()->routeIs('admin.overview')"><i data-feather="grid" class="h-4 w-4"></i>Overview</x-nav-link>
        <x-nav-link href="{{ route('admin.product.index') }}" :active="request()->routeIs('admin.product.*')"><i data-feather="package" class="h-4 w-4"></i>Products</x-nav-link>
        <x-nav-link href="{{ route('admin.categories.index') }}" :active="request()->routeIs('admin.categories.*')"><i data-feather="tag" class="h-4 w-4"></i>Categories</x-nav-link>
        <x-nav-link href="{{ route('admin.orders.index') }}" :active="request()->routeIs('admin.orders.*')"><i data-feather="shopping-bag" class="h-4 w-4"></i>Orders</x-nav-link>
        <x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')"><i data-feather="users" class="h-4 w-4"></i>Customers</x-nav-link>

        <div class="my-4 border-t border-zinc-800"></div>
        <p class="mb-2 px-3 font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-600">Public</p>
        <x-nav-link href="{{ route('feed') }}"><i data-feather="external-link" class="h-4 w-4"></i>View storefront</x-nav-link>
    </nav>

    <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-3.5">
        <div class="flex items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-500 text-xs font-extrabold text-zinc-950">{{ Str::upper(Str::substr(Auth::user()->name,0,1)) }}</span>
            <div class="min-w-0">
                <p class="truncate text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                <p class="truncate text-[10px] text-zinc-500">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <form method="post" action="{{ route('logout') }}" class="mt-3">@csrf<button class="w-full rounded-lg border border-zinc-700 px-3 py-2 text-xs font-semibold text-zinc-400 hover:border-zinc-600 hover:bg-zinc-800 hover:text-white">Sign out</button></form>
    </div>
</aside>
