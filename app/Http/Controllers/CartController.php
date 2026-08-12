<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store(Request $request)
    {
        return redirect()->route('feed');
    }

    public function show(Cart $cart)
    {
        abort_unless($cart->userId === Auth::id(), 403);

        $products = $cart->products()->with('category')->get();

        return view('cart', compact('products'));
    }

    public function update(Request $request, Cart $cart)
    {
        abort_unless($cart->userId === Auth::id(), 403);

        $validated = $request->validate([
            'productId' => ['required', 'uuid', 'exists:products,id'],
        ]);

        $cart->products()->detach($validated['productId']);

        return back()->with('success', 'Item removed from your cart.');
    }

    public function updateQuantity(int $quantity, string $productId): void
    {
        $cart = Auth::user()?->cart;
        $product = Product::findOrFail($productId);

        abort_unless($cart, 404);

        $quantity = max(1, min($quantity, $product->stock));

        $cart->products()->updateExistingPivot($productId, ['quantity' => $quantity]);
    }
}
