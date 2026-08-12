<div class="border-b border-zinc-300/80 bg-[#f4f2ed] text-zinc-600">
    <div class="mx-auto flex max-w-[1600px] items-center justify-between gap-4 px-5 py-2.5 sm:px-8 lg:px-12 xl:px-16">
        <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.2em]">Hardware supply / built for everyday work</p>
        <p class="hidden text-[11px] sm:block">Tools, consumables, repair essentials, and jobsite stock.</p>
    </div>
</div>

<nav class="sticky top-0 z-50 border-b border-zinc-300/80 bg-[#f4f2ed]/95 backdrop-blur-xl">
    <div class="mx-auto max-w-[1600px] px-5 sm:px-8 lg:px-12 xl:px-16">
        <div class="flex min-h-20 items-center gap-5 lg:gap-8">
            <a href="{{ route('feed') }}" class="shrink-0" aria-label="Boltify home">
                <x-application-logo class="text-2xl sm:text-[1.7rem]"/>
            </a>

            <div class="hidden items-center gap-6 lg:flex">
                <a href="{{ route('feed') }}" class="text-sm font-semibold text-zinc-700 hover:text-orange-600">Shop</a>
                <a href="{{ route('feed') }}#departments" class="text-sm font-semibold text-zinc-700 hover:text-orange-600">Departments</a>
            </div>

            <form method="get" action="{{ route('feed') }}" class="hidden min-w-0 flex-1 md:block">
                <label class="group flex items-center border-b border-zinc-400/80 focus-within:border-zinc-950">
                    <i data-feather="search" class="h-4 w-4 shrink-0 text-zinc-500"></i>
                    <input name="search" value="{{ request('search') }}" placeholder="Search the hardware catalog" class="min-w-0 flex-1 border-0 bg-transparent px-3 py-2.5 text-sm text-zinc-950 placeholder:text-zinc-400 focus:ring-0">
                    <span class="hidden font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-400 xl:block">Search</span>
                </label>
            </form>

            <div class="ml-auto flex items-center gap-2 sm:gap-4">
                @auth
                    <a href="{{ route('order.index') }}" class="hidden text-sm font-semibold text-zinc-700 hover:text-orange-600 sm:block">Orders</a>
                    @if(Auth::user()->cart)
                        <a href="{{ route('cart.show',Auth::user()->cart) }}" class="relative inline-flex h-10 w-10 items-center justify-center border border-zinc-400/70 hover:border-zinc-950" aria-label="Shopping cart">
                            <i data-feather="shopping-bag" class="h-[18px] w-[18px]"></i>
                            <livewire:count/>
                        </a>
                    @endif
                    <div x-data="{open:false}" class="relative">
                        <button @click="open=!open" class="flex h-10 items-center gap-2 border border-zinc-400/70 px-3 text-sm font-semibold hover:border-zinc-950">
                            <span class="hidden sm:block">{{ Str::limit(Auth::user()->name,14) }}</span>
                            <i data-feather="chevron-down" class="h-3.5 w-3.5"></i>
                        </button>
                        <div x-cloak x-show="open" x-transition.origin.top.right @click.outside="open=false" class="absolute right-0 mt-3 w-60 border border-zinc-300 bg-[#f8f6f1] p-2 shadow-2xl shadow-zinc-950/10">
                            <div class="border-b border-zinc-200 px-3 py-3">
                                <p class="truncate text-xs font-semibold text-zinc-900">{{ Auth::user()->name }}</p>
                                <p class="mt-1 truncate text-[11px] text-zinc-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="mt-1 block px-3 py-2 text-sm hover:bg-white">Profile</a>
                            <a href="{{ route('order.index') }}" class="block px-3 py-2 text-sm hover:bg-white">My orders</a>
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('admin.overview') }}" class="block px-3 py-2 text-sm font-semibold text-orange-700 hover:bg-white">Admin dashboard</a>
                            @endif
                            <form method="post" action="{{ route('logout') }}" class="mt-1 border-t border-zinc-200 pt-1">
                                @csrf
                                <button class="w-full px-3 py-2 text-left text-sm text-zinc-600 hover:bg-white">Sign out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden text-sm font-semibold text-zinc-700 hover:text-orange-600 sm:inline">Sign in</a>
                    <a href="{{ route('register') }}" class="inline-flex h-10 items-center bg-zinc-950 px-4 text-sm font-bold text-white hover:bg-orange-500 hover:text-zinc-950">Create account</a>
                @endauth
            </div>
        </div>

        <form method="get" action="{{ route('feed') }}" class="pb-4 md:hidden">
            <label class="flex items-center border-b border-zinc-400/80">
                <i data-feather="search" class="h-4 w-4 text-zinc-500"></i>
                <input name="search" value="{{ request('search') }}" placeholder="Search tools and hardware" class="w-full border-0 bg-transparent px-3 py-2 text-sm focus:ring-0">
            </label>
        </form>
    </div>
</nav>
