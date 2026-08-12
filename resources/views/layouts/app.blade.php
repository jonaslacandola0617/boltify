<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name','Boltify') }}</title>
    <x-includes />
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen antialiased">
    @include('layouts.navigation')

    <main class="mx-auto flex min-h-[65vh] w-full max-w-[1440px] flex-col gap-8 px-4 py-6 sm:px-6 lg:px-8 lg:py-10">
        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
        @endif

        {{ $slot }}
    </main>

    <footer class="mt-10 border-t border-zinc-800 bg-zinc-950 text-zinc-400">
        <div class="mx-auto grid max-w-[1440px] gap-8 px-4 py-10 sm:px-6 md:grid-cols-[1.3fr_1fr] lg:px-8">
            <div class="max-w-xl">
                <x-application-logo class="text-2xl text-white" />
                <p class="mt-4 max-w-md text-sm leading-6 text-zinc-500">A practical digital hardware counter for tools, building supplies, maintenance essentials, and everyday repair work.</p>
            </div>
            <div class="grid grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.18em] text-zinc-600">Shop</p>
                    <div class="mt-3 space-y-2">
                        <a href="{{ route('feed') }}" class="block hover:text-white">Catalog</a>
                        @auth<a href="{{ route('order.index') }}" class="block hover:text-white">My orders</a>@endauth
                    </div>
                </div>
                <div>
                    <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.18em] text-zinc-600">Store</p>
                    <div class="mt-3 space-y-2">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="block hover:text-white">Account</a>
                            @if(Auth::user()->is_admin)<a href="{{ route('admin.overview') }}" class="block hover:text-white">Administration</a>@endif
                        @else
                            <a href="{{ route('login') }}" class="block hover:text-white">Sign in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-zinc-900">
            <div class="mx-auto flex max-w-[1440px] flex-col gap-1 px-4 py-4 text-[11px] text-zinc-600 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p>© {{ date('Y') }} Boltify Hardware Supply.</p>
                <p class="font-mono uppercase tracking-[0.12em]">Built for the job</p>
            </div>
        </div>
    </footer>

    <script>document.addEventListener('DOMContentLoaded',()=>feather.replace());document.addEventListener('livewire:navigated',()=>feather.replace());</script>
    @livewireScripts
</body>
</html>
