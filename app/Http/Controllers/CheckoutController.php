<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart;
        $products = $cart?->products()->with('category')->get() ?? collect();

        if ($products->isEmpty()) {
            return redirect()->route('feed')->with('error', 'Your cart is empty.');
        }

        $summary = $products->map(function ($product) {
            return [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'description' => $product->description,
                'category' => $product->category->name,
                'images' => json_decode($product->images, true) ?: [],
                'totalPrice' => $product->price * $product->pivot->quantity,
            ];
        });

        $subTotal = $products->sum(fn ($product) => $product->price * $product->pivot->quantity);
        $count = $products->sum(fn ($product) => $product->pivot->quantity);

        return view('checkout.index', compact('summary', 'count', 'subTotal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'in:card'],
        ]);

        $products = Auth::user()->cart?->products()->with('category')->get() ?? collect();

        if ($products->isEmpty()) {
            return redirect()->route('feed')->with('error', 'Your cart is empty.');
        }

        foreach ($products as $product) {
            if ($product->pivot->quantity > $product->stock) {
                throw ValidationException::withMessages([
                    'cart' => "{$product->name} only has {$product->stock} item(s) left.",
                ]);
            }
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $lineItems = $products->map(function ($product) {
                return [
                    'price_data' => [
                        'currency' => 'php',
                        'product_data' => ['name' => $product->name],
                        'unit_amount' => (int) round($product->price * 100),
                    ],
                    'quantity' => $product->pivot->quantity,
                ];
            })->values()->toArray();

            $session = Session::create([
                'mode' => 'payment',
                'client_reference_id' => (string) Auth::id(),
                'metadata' => ['user_id' => (string) Auth::id()],
                'payment_method_types' => [$validated['payment_method']],
                'line_items' => $lineItems,
                'customer_email' => Auth::user()->email,
                'shipping_address_collection' => ['allowed_countries' => ['PH']],
                'shipping_options' => [[
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => ['amount' => 5800, 'currency' => 'php'],
                        'display_name' => 'Standard Shipping',
                        'delivery_estimate' => [
                            'minimum' => ['unit' => 'business_day', 'value' => 3],
                            'maximum' => ['unit' => 'business_day', 'value' => 7],
                        ],
                    ],
                ]],
                'success_url' => url('/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => route('checkout.index'),
            ]);

            return redirect($session->url);
        } catch (ApiErrorException $exception) {
            Log::error('Stripe checkout failed', ['message' => $exception->getMessage()]);

            return back()->with('error', 'Checkout could not be started. Please try again.');
        }
    }

    public function success(Request $request)
    {
        $cart = Auth::user()->cart;
        $session = $request->input('session');

        $existingOrder = Order::where('payment_intent', $session->payment_intent)->first();

        if ($existingOrder) {
            return view('checkout.success', ['order' => $existingOrder]);
        }

        $order = DB::transaction(function () use ($cart, $session) {
            $cartProducts = $cart->products()->get();

            foreach ($cartProducts as $product) {
                $lockedProduct = Product::query()->lockForUpdate()->findOrFail($product->id);
                $quantity = (int) $product->pivot->quantity;

                if ($lockedProduct->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'cart' => "{$lockedProduct->name} no longer has enough stock to complete this order.",
                    ]);
                }
            }

            $shippingAddress = $session->shipping_details->address;

            $order = Order::create([
                'userId' => Auth::id(),
                'total' => $session->amount_total,
                'status' => $session->status,
                'payment_intent' => $session->payment_intent,
                'payment_status' => $session->payment_status,
                'payment_method' => $session->payment_method_types[0],
                'name' => $session->shipping_details->name,
                'email' => $session->customer_email,
                'address' => trim(implode(' ', array_filter([$shippingAddress->line1, $shippingAddress->line2]))),
                'city' => $shippingAddress->city,
                'country' => $shippingAddress->country,
                'refund_status' => null,
                'refund_reason' => null,
                'stock_deducted' => true,
            ]);

            $order->products()->attach(
                $cartProducts->mapWithKeys(fn ($product) => [
                    $product->id => [
                        'quantity' => $product->pivot->quantity,
                        'unit_price' => $product->price,
                    ],
                ])->toArray()
            );

            foreach ($cartProducts as $product) {
                Product::whereKey($product->id)->decrement('stock', (int) $product->pivot->quantity);
            }

            $cart->products()->detach();

            return $order;
        });

        return view('checkout.success', compact('order'));
    }
}
