<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductCard extends Component
{
    public $product;
    public int $quantity = 1;

    public function mount($product): void { $this->product = $product; }
    public function render() { return view('livewire.product-card'); }
    public function open() { return $this->redirect(route('product.show', $this->product->id), navigate: false); }

    public function store()
    {
        if (! Auth::check()) return $this->redirect(route('login'), navigate: false);
        $this->product->refresh();
        if ($this->product->stock < 1) return;

        $cart = Auth::user()->cart ?: Cart::create(['userId' => Auth::id()]);
        $existing = $cart->products()->wherePivot('productId', $this->product->id)->first();
        $currentQuantity = $existing?->pivot->quantity ?? 0;
        $nextQuantity = min($currentQuantity + $this->quantity, $this->product->stock);

        if ($existing) $cart->products()->updateExistingPivot($this->product->id, ['quantity' => $nextQuantity]);
        else $cart->products()->attach($this->product->id, ['quantity' => $nextQuantity]);

        $this->dispatch('cart/updated');
    }
}
