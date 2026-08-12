<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            [
                'payment_intent' => 'pi_demo_boltify_001',
                'email' => 'customer@boltify.test',
                'days_ago' => 2,
                'status' => 'complete',
                'lines' => [
                    '16oz Claw Hammer' => 1,
                    'Wood Screws Assorted 200pc' => 2,
                    'Anti-Fog Safety Goggles' => 1,
                ],
            ],
            [
                'payment_intent' => 'pi_demo_boltify_002',
                'email' => 'andrea@boltify.test',
                'days_ago' => 0,
                'status' => 'pending',
                'lines' => [
                    'Premium Interior Latex Paint 4L' => 2,
                    'Paint Roller Set 9-inch' => 1,
                ],
            ],
            [
                'payment_intent' => 'pi_demo_boltify_003',
                'email' => 'miguel@boltify.test',
                'days_ago' => 18,
                'status' => 'complete',
                'lines' => [
                    '12V Cordless Drill Driver' => 1,
                    '6-piece Screwdriver Set' => 1,
                    'Electrical Tape 10-pack' => 1,
                ],
            ],
            [
                'payment_intent' => 'pi_demo_boltify_004',
                'email' => 'carlo@boltify.test',
                'days_ago' => 37,
                'status' => 'refunded',
                'lines' => [
                    '4-inch Angle Grinder 850W' => 1,
                    'Reusable Dust Mask with Filters' => 1,
                ],
            ],
            [
                'payment_intent' => 'pi_demo_boltify_005',
                'email' => 'patricia@boltify.test',
                'days_ago' => 64,
                'status' => 'complete',
                'lines' => [
                    'Marine Plywood 1/2-inch 4x8' => 2,
                    'Construction Adhesive 300ml' => 3,
                    '5m Auto-Lock Tape Measure' => 1,
                ],
            ],
            [
                'payment_intent' => 'pi_demo_boltify_006',
                'email' => 'customer@boltify.test',
                'days_ago' => 95,
                'status' => 'complete',
                'lines' => [
                    'Heavy-Duty Extension Cord 10m' => 1,
                    'Universal Convenience Outlet' => 4,
                    'Nitrile-Coated Work Gloves' => 2,
                ],
            ],
            [
                'payment_intent' => 'pi_demo_boltify_007',
                'email' => 'andrea@boltify.test',
                'days_ago' => 129,
                'status' => 'complete',
                'lines' => [
                    '10-inch Adjustable Wrench' => 1,
                    'Adjustable Pipe Wrench 14-inch' => 1,
                    'PTFE Thread Seal Tape 10-pack' => 2,
                ],
            ],
            [
                'payment_intent' => 'pi_demo_boltify_008',
                'email' => 'miguel@boltify.test',
                'days_ago' => 157,
                'status' => 'complete',
                'lines' => [
                    '20V Brushless Impact Driver' => 1,
                    'Hex Bolt & Nut Set M8 20pc' => 2,
                    'Vented Safety Hard Hat' => 1,
                ],
            ],
        ];

        foreach ($orders as $index => $seed) {
            $user = User::query()->where('email', $seed['email'])->firstOrFail();
            $products = Product::query()->whereIn('name', array_keys($seed['lines']))->get()->keyBy('name');

            $total = collect($seed['lines'])->sum(function (int $quantity, string $productName) use ($products) {
                return (float) $products[$productName]->price * $quantity;
            });

            $isRefunded = $seed['status'] === 'refunded';
            $isPending = $seed['status'] === 'pending';

            $order = Order::query()->updateOrCreate(
                ['payment_intent' => $seed['payment_intent']],
                [
                    'userId' => $user->id,
                    'total' => (int) round($total * 100),
                    'status' => $seed['status'],
                    'payment_status' => $isPending ? 'unpaid' : ($isRefunded ? 'refunded' : 'paid'),
                    'payment_method' => 'card',
                    'name' => $user->name,
                    'email' => $user->email,
                    'address' => ($index + 18).' Demo Street, Barangay San Isidro',
                    'city' => 'Mabalacat City',
                    'country' => 'Philippines',
                    'refund' => $isRefunded ? 're_demo_boltify_004' : null,
                    'refund_status' => $isRefunded ? 'succeeded' : null,
                    'refund_reason' => $isRefunded ? 'requested_by_customer' : null,
                    'refund_completed_at' => $isRefunded ? now()->subDays($seed['days_ago'])->addHours(3) : null,
                    'stock_deducted' => false,
                ],
            );

            $pivot = [];
            foreach ($seed['lines'] as $productName => $quantity) {
                $product = $products[$productName];
                $pivot[$product->id] = [
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                ];
            }

            $order->products()->sync($pivot);

            $createdAt = now()->subDays($seed['days_ago'])->setTime(10 + ($index % 6), 15);
            $order->forceFill([
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ])->save();
        }
    }
}
