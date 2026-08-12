<x-guest-layout title="Create an account — Boltify" description="Create a Boltify account for faster hardware shopping, saved cart access, and order tracking.">
    <x-slot name="sideboard">
        <div class="max-w-xl">
            <div class="flex items-center gap-3 font-mono text-[10px] font-semibold uppercase tracking-[0.22em] text-zinc-500">
                <span class="h-2 w-2 bg-orange-500"></span>
                New account / 01
            </div>
            <h2 class="mt-7 text-6xl font-extrabold leading-[0.92] tracking-[-0.07em] xl:text-7xl">Your hardware<br><span class="text-orange-600">run, simplified.</span></h2>
            <p class="mt-7 max-w-md text-base leading-8 text-zinc-600">Create one account for the catalog, cart, checkout, and order history. No loyalty gimmicks—just a faster route from what you need to what gets the job done.</p>
            <div class="mt-12 border-t border-zinc-300/80 pt-6">
                <p class="max-w-sm text-xs leading-6 text-zinc-500">Built with the clarity of a trade counter and the convenience of modern commerce.</p>
            </div>
        </div>
    </x-slot>

    <div class="mb-10">
        <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-orange-600">Start here</p>
        <h1 class="mt-3 text-4xl font-extrabold tracking-[-0.055em] sm:text-5xl">Create your account.</h1>
        <p class="mt-4 text-sm leading-7 text-zinc-600">A few details and you’re ready to shop, save a cart, and track your orders.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-7">
        @csrf

        <div>
            <label for="name" class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Full name</label>
            <div class="mt-2 flex items-center border-b border-zinc-400 focus-within:border-zinc-950">
                <i data-feather="user" class="h-4 w-4 shrink-0 text-zinc-400"></i>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your name" class="w-full border-0 bg-transparent px-3 py-3 text-sm placeholder:text-zinc-400 focus:ring-0">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Email address</label>
            <div class="mt-2 flex items-center border-b border-zinc-400 focus-within:border-zinc-950">
                <i data-feather="mail" class="h-4 w-4 shrink-0 text-zinc-400"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com" class="w-full border-0 bg-transparent px-3 py-3 text-sm placeholder:text-zinc-400 focus:ring-0">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid gap-7 sm:grid-cols-2">
            <div>
                <label for="password" class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Password</label>
                <div class="mt-2 flex items-center border-b border-zinc-400 focus-within:border-zinc-950">
                    <i data-feather="lock" class="h-4 w-4 shrink-0 text-zinc-400"></i>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create password" class="w-full border-0 bg-transparent px-3 py-3 text-sm placeholder:text-zinc-400 focus:ring-0">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="font-mono text-[9px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Confirm</label>
                <div class="mt-2 flex items-center border-b border-zinc-400 focus-within:border-zinc-950">
                    <i data-feather="shield" class="h-4 w-4 shrink-0 text-zinc-400"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password" class="w-full border-0 bg-transparent px-3 py-3 text-sm placeholder:text-zinc-400 focus:ring-0">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <button type="submit" class="flex w-full items-center justify-between border-y border-zinc-950 bg-zinc-950 px-5 py-4 text-sm font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950">
            <span>Create account</span><span aria-hidden="true">→</span>
        </button>

        <p class="text-center text-sm text-zinc-500">Already have an account? <a href="{{ route('login') }}" class="font-bold text-zinc-950 underline decoration-zinc-300 underline-offset-4 hover:text-orange-600">Sign in</a></p>
    </form>
</x-guest-layout>
