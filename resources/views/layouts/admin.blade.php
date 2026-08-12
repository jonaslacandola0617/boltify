<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin · {{ config('app.name', 'Boltify') }}</title>
    <meta name="robots" content="noindex,nofollow">
    <x-includes />
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen antialiased" x-data="{ sidebarOpen:false }">
    <div class="min-h-screen lg:grid lg:grid-cols-[17rem_1fr]">
        @include('layouts.sidebar')
        <div class="min-w-0 bg-[#f4f2ed]">
            <header class="sticky top-0 z-30 flex items-center justify-between border-b border-zinc-800 bg-zinc-950 px-4 py-3 text-white lg:hidden">
                <button @click="sidebarOpen=true" class="border border-zinc-700 p-2 text-zinc-300"><i data-feather="menu" class="h-5 w-5"></i></button>
                <x-application-logo class="text-xl text-white" />
                <a href="{{ route('feed') }}" class="border border-zinc-700 p-2 text-zinc-300"><i data-feather="external-link" class="h-5 w-5"></i></a>
            </header>

            <main class="mx-auto flex max-w-[1500px] flex-col gap-7 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                @if(session('success'))<div class="border-l-2 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>@endif
                @if(session('error'))<div class="border-l-2 border-red-500 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">{{ session('error') }}</div>@endif
                @if($errors->any())<div class="border-l-2 border-red-500 bg-red-50 px-4 py-3 text-sm text-red-800">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>document.addEventListener('DOMContentLoaded',()=>feather.replace());document.addEventListener('livewire:navigated',()=>feather.replace());</script>
    @livewireScripts
</body>
</html>
