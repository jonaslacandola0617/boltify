<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Count extends Component
{
    public int $count = 0;

    public function mount(): void { $this->count(); }
    public function render() { return view('livewire.count'); }

    #[On('cart/updated')]
    public function count(): void
    {
        $cart = Auth::user()?->cart;
        $this->count = $cart ? (int) $cart->products()->get()->sum(fn ($product) => $product->pivot->quantity) : 0;
    }
}
