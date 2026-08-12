<div class="border-b border-zinc-800 bg-zinc-950 text-zinc-300">
    <div class="mx-auto flex max-w-[1440px] items-center justify-between gap-4 px-4 py-2 sm:px-6 lg:px-8">
        <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] sm:text-[10px]">Hardware · Tools · Jobsite essentials</p>
        <p class="hidden text-[11px] text-zinc-500 sm:block">Built for repairs, builds, and everything in between.</p>
    </div>
</div>

<nav class="sticky top-0 z-50 border-b border-zinc-200/90 bg-[#f9f8f5]/95 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1440px] items-center gap-4 px-4 py-3.5 sm:px-6 lg:px-8">
        <a href="{{ route('feed') }}" class="shrink-0" aria-label="Boltify home">
            <x-application-logo class="text-xl sm:text-2xl"/>
        </a>

        <a href="{{ route('feed') }}" class="hidden rounded-lg px-3 py-2 text-sm font-semibold text-zinc-600 hover:bg-white hover:text-zinc-950 lg:block">Catalog</a>

        <form method="get" action="{{ route('feed') }}" class="hidden min-w-0 flex-1 sm:flex">
            <div class="flex w-full items-center overflow-hidden rounded-xl border border-zinc-300 bg-white shadow-sm focus-within:border-zinc-500 focus-within:ring-2 focus-within:ring-orange-500/10">
                <span class="pl-4 text-zinc-400"><i data-feather="search" class="h-4 w-4"></i></span>
                <input name="search" value="{{ request('search') }}" placeholder="Search drills, fasteners, paint, safety gear…" class="min-w-0 flex-1 border-0 bg-transparent px-3 py-2.5 text-sm placeholder:text-zinc-400 focus:ring-0">
                <button class="m-1 rounded-lg bg-zinc-950 px-4 py-2 text-xs font-bold uppercase tracking-wide text-white hover:bg-orange-500 hover:text-zinc-950">Search</button>
            </div>
        </form>

        <div class="ml-auto flex items-center gap-1.5">
            @auth
                <a href="{{ route('order.index') }}" class="hidden rounded-lg px-3 py-2 text-sm font-semibold text-zinc-600 hover:bg-white hover:text-zinc-950 md:block">Orders</a>
                @if(Auth::user()->cart)
                    <a href="{{ route('cart.show',Auth::user()->cart) }}" class="relative rounded-xl border border-zinc-200 bg-white p-2.5 shadow-sm hover:border-zinc-300" aria-label="Shopping cart">
                        <i data-feather="shopping-bag" class="h-5 w-5"></i>
                        <livewire:count/>
                    </a>
                @endif
                <div x-data="{open:false}" class="relative">
                    <button @click="open=!open" class="flex items-center gap-2 rounded-xl border border-zinc-200 bg-white px-3 py-2.5 text-sm font-semibold shadow-sm hover:border-zinc-300">
                        <span class="hidden sm:block">{{ Str::limit(Auth::user()->name,16) }}</span>
                        <i data-feather="chevron-down" class="h-3.5 w-3.5"></i>
                    </button>
                    <div x-cloak x-show="open" x-transition.origin.top.right @click.outside="open=false" class="absolute right-0 mt-2 w-56 rounded-2xl border border-zinc-200 bg-white p-2 shadow-xl shadow-zinc-950/10">
                        <div class="border-b border-zinc-100 px-3 py-2.5">
                            <p class="truncate text-xs font-semibold text-zinc-900">{{ Auth::user()->name }}</p>
                            <p class="truncate text-[11px] text-zinc-400">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="mt-1 block rounded-lg px-3 py-2 text-sm hover:bg-zinc-50">Profile</a>
                        <a href="{{ route('order.index') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-zinc-50">My orders</a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.overview') }}" class="block rounded-lg bg-orange-50 px-3 py-2 text-sm font-semibold text-orange-700 hover:bg-orange-100">Admin dashboard</a>
                        @endif
                        <form method="post" action="{{ route('logout') }}" class="mt-1 border-t border-zinc-100 pt-1">
                            @csrf
                            <button class="w-full rounded-lg px-3 py-2 text-left text-sm text-zinc-600 hover:bg-zinc-50">Sign out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-bold text-white hover:bg-orange-500 hover:text-zinc-950">Sign in</a>
            @endauth
        </div>
    </div>

    <form method="get" action="{{ route('feed') }}" class="mx-auto flex max-w-[1440px] px-4 pb-3.5 sm:hidden">
        <div class="flex w-full items-center rounded-xl border border-zinc-300 bg-white px-3 shadow-sm">
            <i data-feather="search" class="h-4 w-4 text-zinc-400"></i>
            <input name="search" value="{{ request('search') }}" placeholder="Search the hardware catalog" class="w-full border-0 bg-transparent text-sm focus:ring-0">
        </div>
    </form>
</nav>
