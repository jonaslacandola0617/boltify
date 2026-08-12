<div x-cloak x-show="sidebarOpen" @click="sidebarOpen=false" class="fixed inset-0 z-40 bg-zinc-950/40 lg:hidden"></div>
<aside class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-zinc-200 bg-white p-4 transition-transform lg:sticky lg:top-0 lg:h-screen lg:w-auto lg:translate-x-0" :class="{'translate-x-0':sidebarOpen}">
    <div class="flex items-center justify-between px-2 py-2"><a href="{{ route('admin.overview') }}" class="flex items-center gap-2"><x-application-logo class="text-2xl"/><span class="rounded-full bg-orange-100 px-2 py-1 text-[10px] font-bold uppercase text-orange-700">Admin</span></a><button @click="sidebarOpen=false" class="lg:hidden"><i data-feather="x"></i></button></div>
    <nav class="mt-7 flex flex-1 flex-col gap-1">
        <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-widest text-zinc-400">Workspace</p>
        <x-nav-link href="{{ route('admin.overview') }}" :active="request()->routeIs('admin.overview')"><i data-feather="grid" class="h-4 w-4"></i>Overview</x-nav-link>
        <x-nav-link href="{{ route('admin.product.index') }}" :active="request()->routeIs('admin.product.*')"><i data-feather="package" class="h-4 w-4"></i>Products</x-nav-link>
        <x-nav-link href="{{ route('admin.categories.index') }}" :active="request()->routeIs('admin.categories.*')"><i data-feather="tag" class="h-4 w-4"></i>Categories</x-nav-link>
        <x-nav-link href="{{ route('admin.orders.index') }}" :active="request()->routeIs('admin.orders.*')"><i data-feather="shopping-bag" class="h-4 w-4"></i>Orders</x-nav-link>
        <x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')"><i data-feather="users" class="h-4 w-4"></i>Customers</x-nav-link>
        <div class="my-4 border-t"></div>
        <x-nav-link href="{{ route('feed') }}"><i data-feather="external-link" class="h-4 w-4"></i>View storefront</x-nav-link>
    </nav>
    <div class="rounded-2xl border bg-zinc-50 p-3"><p class="truncate text-sm font-semibold">{{ Auth::user()->name }}</p><p class="truncate text-xs text-zinc-500">{{ Auth::user()->email }}</p><form method="post" action="{{ route('logout') }}" class="mt-3">@csrf<button class="w-full rounded-lg border bg-white px-3 py-2 text-xs font-medium">Sign out</button></form></div>
</aside>
