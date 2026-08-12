<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Quantity extends Component
{
    public int $quantity = 1;
    public string $product;

    public function mount($quantity, $product): void { $this->quantity = max(1, (int) $quantity); $this->product = (string) $product; }

    public function increment(): void
    {
        $product = Product::findOrFail($this->product);
        if ($this->quantity >= $product->stock) return;
        $this->quantity++;
        $this->sync();
    }

    public function decrement(): void
    {
        if ($this->quantity <= 1) return;
        $this->quantity--;
        $this->sync();
    }

    public function render() { return view('livewire.quantity'); }

    private function sync(): void
    {
        $cart = Auth::user()?->cart;
        abort_unless($cart, 404);
        $cart->products()->updateExistingPivot($this->product, ['quantity' => $this->quantity]);
        $this->dispatch('quantity/changed');
        $this->dispatch('cart/updated');
    }
}
