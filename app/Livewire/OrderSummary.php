<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class OrderSummary extends Component
{
    public $summary = [];
    public int $count = 0;
    public float $subTotal = 0;

    public function mount(): void { $this->renderSummary(); }
    public function render() { return view('livewire.order-summary'); }

    #[On('quantity/changed')]
    public function renderSummary(): void
    {
        $products = Auth::user()->cart->products()->get();
        $this->summary = $products->map(fn ($product) => [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $product->pivot->quantity,
            'totalPrice' => $product->price * $product->pivot->quantity,
        ])->toArray();
        $this->subTotal = (float) $products->sum(fn ($product) => $product->price * $product->pivot->quantity);
        $this->count = (int) $products->sum(fn ($product) => $product->pivot->quantity);
    }
}
