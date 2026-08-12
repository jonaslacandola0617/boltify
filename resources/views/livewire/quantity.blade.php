<div class="inline-flex items-center border-y border-zinc-400">
    <button type="button" wire:click="decrement" @disabled($quantity<=1) class="flex h-9 w-9 items-center justify-center text-lg text-zinc-600 hover:text-orange-600 disabled:opacity-30">−</button>
    <span class="min-w-10 border-x border-zinc-300 text-center text-sm font-semibold leading-9">{{ $quantity }}</span>
    <button type="button" wire:click="increment" class="flex h-9 w-9 items-center justify-center text-lg text-zinc-600 hover:text-orange-600">+</button>
</div>
