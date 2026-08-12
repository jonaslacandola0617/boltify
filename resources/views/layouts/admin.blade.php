<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin · {{ config('app.name', 'Boltify') }}</title>
    <x-includes />
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-zinc-100 antialiased" x-data="{ sidebarOpen:false }">
<div class="min-h-screen lg:grid lg:grid-cols-[17rem_1fr]">
    @include('layouts.sidebar')
    <div class="min-w-0">
        <header class="sticky top-0 z-30 flex items-center justify-between border-b border-zinc-200 bg-white px-4 py-3 lg:hidden">
            <button @click="sidebarOpen=true" class="rounded-lg border p-2"><i data-feather="menu" class="h-5 w-5"></i></button>
            <x-application-logo class="text-xl" />
            <a href="{{ route('feed') }}" class="rounded-lg border p-2"><i data-feather="external-link" class="h-5 w-5"></i></a>
        </header>
        <main class="mx-auto flex max-w-[1500px] flex-col gap-8 px-4 py-6 sm:px-6 lg:px-8">
            @if(session('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>@endif
            @if($errors->any())<div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
            {{ $slot }}
        </main>
    </div>
</div>
<script>document.addEventListener('DOMContentLoaded',()=>feather.replace());document.addEventListener('livewire:navigated',()=>feather.replace());</script>
@livewireScripts
</body></html>
