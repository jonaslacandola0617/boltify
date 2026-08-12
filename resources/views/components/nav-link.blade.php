@props(['active'=>false])
@php($classes=$active
    ? 'flex items-center gap-3 rounded-xl bg-orange-500 px-3 py-2.5 text-sm font-extrabold text-zinc-950 shadow-sm shadow-orange-500/10'
    : 'flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-zinc-400 hover:bg-zinc-900 hover:text-white')
<a {{ $attributes->merge(['class'=>$classes]) }}>{{ $slot }}</a>
