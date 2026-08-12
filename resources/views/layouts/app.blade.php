<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    @php
        $seoTitle = $title ?: 'Boltify — Tools, Hardware & Jobsite Essentials';
        $seoDescription = $description ?: 'Shop dependable tools, hardware supplies, fasteners, electrical, plumbing, safety gear, and jobsite essentials from Boltify.';
        $seoCanonical = $canonical ?: url()->current();
        $seoImage = $image ?: asset('favicon.ico');
        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'Boltify',
            'url' => route('feed'),
            'description' => 'Tools, hardware supplies, and jobsite essentials.',
        ];
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="{{ $noindex ? 'noindex,follow' : 'index,follow,max-image-preview:large' }}">
    <link rel="canonical" href="{{ $seoCanonical }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Boltify">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <script type="application/ld+json">{!! json_encode($websiteSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    @foreach($jsonLd as $schema)
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    @endforeach

    <x-includes />
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-[#f4f2ed] text-zinc-950 antialiased">
    @include('layouts.navigation')

    <main class="mx-auto flex min-h-[68vh] w-full max-w-[1600px] flex-col px-5 pb-16 pt-8 sm:px-8 lg:px-12 lg:pt-12 xl:px-16">
        @if(session('success'))
            <div class="mb-8 border-l-2 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-8 border-l-2 border-red-500 bg-red-50 px-4 py-3 text-sm font-medium text-red-900">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-8 border-l-2 border-red-500 bg-red-50 px-4 py-3 text-sm text-red-900">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
        @endif

        {{ $slot }}
    </main>

    <footer class="border-t border-zinc-300/80 bg-[#ebe8e1]">
        <div class="mx-auto max-w-[1600px] px-5 py-14 sm:px-8 lg:px-12 xl:px-16">
            <div class="grid gap-12 lg:grid-cols-[1.4fr_.6fr_.6fr]">
                <div class="max-w-xl">
                    <x-application-logo class="text-3xl text-zinc-950" />
                    <p class="mt-5 max-w-md text-sm leading-7 text-zinc-600">A sharper way to source the everyday things that keep work moving—from the bench, to the wall, to the jobsite.</p>
                    <div class="mt-8 flex items-center gap-3 font-mono text-[10px] font-semibold uppercase tracking-[0.18em] text-zinc-500">
                        <span class="inline-block h-2 w-2 bg-orange-500"></span>
                        Hardware / tools / supplies
                    </div>
                </div>
                <div>
                    <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Browse</p>
                    <div class="mt-5 space-y-3 text-sm font-semibold">
                        <a href="{{ route('feed') }}" class="block hover:text-orange-600">Catalog</a>
                        @auth<a href="{{ route('order.index') }}" class="block hover:text-orange-600">My orders</a>@endauth
                    </div>
                </div>
                <div>
                    <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.18em] text-zinc-500">Account</p>
                    <div class="mt-5 space-y-3 text-sm font-semibold">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="block hover:text-orange-600">Profile</a>
                            @if(Auth::user()->is_admin)<a href="{{ route('admin.overview') }}" class="block hover:text-orange-600">Administration</a>@endif
                        @else
                            <a href="{{ route('login') }}" class="block hover:text-orange-600">Sign in</a>
                            <a href="{{ route('register') }}" class="block hover:text-orange-600">Create account</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-zinc-300/80">
            <div class="mx-auto flex max-w-[1600px] flex-col gap-2 px-5 py-5 text-[11px] text-zinc-500 sm:flex-row sm:items-center sm:justify-between sm:px-8 lg:px-12 xl:px-16">
                <p>© {{ date('Y') }} Boltify Hardware Supply.</p>
                <p class="font-mono uppercase tracking-[0.16em]">Built around the work</p>
            </div>
        </div>
    </footer>

    <script>document.addEventListener('DOMContentLoaded',()=>feather.replace());document.addEventListener('livewire:navigated',()=>feather.replace());</script>
    @livewireScripts
</body>
</html>
