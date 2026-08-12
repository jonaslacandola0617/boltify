<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;
    public int $quantity = 1;

    public function mount(Product $product): void { $this->product = $product; }
    public function increment(): void { $this->product->refresh(); $this->quantity = min($this->quantity + 1, max($this->product->stock, 1)); }
    public function decrement(): void { $this->quantity = max(1, $this->quantity - 1); }

    public function addToCart()
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

    public function render() { return view('livewire.product-detail'); }
}
