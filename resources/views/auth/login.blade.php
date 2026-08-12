<x-guest-layout title="Sign in — Boltify" description="Sign in to your Boltify account to manage your cart, orders, and hardware purchases.">
    <x-slot name="sideboard">
        <div class="max-w-xl">
            <div class="flex items-center gap-3 font-mono text-[10px] font-semibold uppercase tracking-[0.22em] text-zinc-500">
                <span class="h-2 w-2 bg-orange-500"></span>
                Account / trade counter
            </div>
            <h2 class="mt-7 text-6xl font-extrabold leading-[0.92] tracking-[-0.07em] xl:text-7xl">Back to the<br><span class="text-orange-600">workbench.</span></h2>
            <p class="mt-7 max-w-md text-base leading-8 text-zinc-600">Pick up where you left off. Your cart, order history, and account details stay together without getting in the way of the work.</p>
            <div class="mt-12 grid grid-cols-2 gap-8 border-t border-zinc-300/80 pt-6">
                <div>
                    <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Catalog</p>
                    <p class="mt-2 text-sm font-bold">Tools & supplies</p>
                </div>
                <div>
                    <p class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Account</p>
                    <p class="mt-2 text-sm font-bold">Orders & cart</p>
                </div>
            </div>
        </div>
    </x-slot>

    <x-auth-session-status class="mb-6 border-l-2 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm text-emerald-900" :status="session('status')" />

    <div class="mb-10">
        <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-orange-600">Welcome back</p>
        <h1 class="mt-3 text-4xl font-extrabold tracking-[-0.055em] sm:text-5xl">Sign in to Boltify.</h1>
        <p class="mt-4 text-sm leading-7 text-zinc-600">Use your account to continue shopping, review orders, or access administration.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-7">
        @csrf

        <div>
            <label for="email" class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Email address</label>
            <div class="mt-2 flex items-center border-b border-zinc-400 focus-within:border-zinc-950">
                <i data-feather="mail" class="h-4 w-4 shrink-0 text-zinc-400"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com" class="w-full border-0 bg-transparent px-3 py-3 text-sm placeholder:text-zinc-400 focus:ring-0">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between gap-4">
                <label for="password" class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-zinc-500 hover:text-orange-600" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            <div class="mt-2 flex items-center border-b border-zinc-400 focus-within:border-zinc-950">
                <i data-feather="lock" class="h-4 w-4 shrink-0 text-zinc-400"></i>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Your password" class="w-full border-0 bg-transparent px-3 py-3 text-sm placeholder:text-zinc-400 focus:ring-0">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="inline-flex cursor-pointer items-center gap-3 text-sm text-zinc-600">
            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded-none border-zinc-400 text-orange-600 focus:ring-orange-500">
            Keep me signed in
        </label>

        <button type="submit" class="flex w-full items-center justify-between border-y border-zinc-950 bg-zinc-950 px-5 py-4 text-sm font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950">
            <span>Sign in</span><span aria-hidden="true">→</span>
        </button>

        <p class="text-center text-sm text-zinc-500">New to Boltify? <a href="{{ route('register') }}" class="font-bold text-zinc-950 underline decoration-zinc-300 underline-offset-4 hover:text-orange-600">Create an account</a></p>
    </form>
</x-guest-layout>
