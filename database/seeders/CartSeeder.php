<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        foreach (User::query()->get() as $user) {
            Cart::query()->firstOrCreate(['userId' => $user->id]);
        }

        $customer = User::query()->where('email', 'customer@boltify.test')->firstOrFail();
        $cart = Cart::query()->where('userId', $customer->id)->firstOrFail();

        $products = Product::query()
            ->whereIn('name', [
                '12V Cordless Drill Driver',
                '5m Auto-Lock Tape Measure',
                'Nitrile-Coated Work Gloves',
            ])
            ->get()
            ->keyBy('name');

        $cart->products()->sync([
            $products['12V Cordless Drill Driver']->id => ['quantity' => 1],
            $products['5m Auto-Lock Tape Measure']->id => ['quantity' => 1],
            $products['Nitrile-Coated Work Gloves']->id => ['quantity' => 2],
        ]);
    }
}
