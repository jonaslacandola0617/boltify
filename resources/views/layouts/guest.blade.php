<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $seoTitle = $title ?: 'Account — Boltify';
        $seoDescription = $description ?: 'Sign in or create your Boltify hardware supply account.';
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="noindex,follow">
    <x-includes/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f4f2ed] text-zinc-950 antialiased">
    <header class="absolute inset-x-0 top-0 z-20">
        <div class="mx-auto flex max-w-[1600px] items-center justify-between px-5 py-6 sm:px-8 lg:px-12 xl:px-16">
            <a href="{{ route('feed') }}" aria-label="Boltify home"><x-application-logo class="text-2xl" /></a>
            <a href="{{ route('feed') }}" class="inline-flex items-center gap-2 text-xs font-bold text-zinc-600 hover:text-orange-600">Back to catalog <span aria-hidden="true">↗</span></a>
        </div>
    </header>

    <main class="mx-auto grid min-h-screen max-w-[1600px] lg:grid-cols-2">
        @isset($sideboard)
            <aside class="relative hidden overflow-hidden border-r border-zinc-300/80 px-12 pb-14 pt-32 lg:flex xl:px-16">
                <div class="hardware-grid absolute inset-0 opacity-40"></div>
                <div class="relative flex w-full flex-col justify-end">
                    {{ $sideboard }}
                </div>
            </aside>
        @endisset

        <section class="flex min-h-screen items-center px-5 pb-16 pt-28 sm:px-8 lg:px-14 lg:py-28 xl:px-20 {{ isset($sideboard) ? '' : 'lg:col-span-2' }}">
            <div class="mx-auto w-full max-w-xl">
                {{ $slot }}
            </div>
        </section>
    </main>

    <script>document.addEventListener('DOMContentLoaded',()=>feather.replace());</script>
</body>
</html>
