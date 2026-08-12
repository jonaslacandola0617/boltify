<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Boltify Admin',
                'email' => 'admin@boltify.test',
                'password' => 'password',
                'is_admin' => true,
            ],
            [
                'name' => 'Demo Customer',
                'email' => 'customer@boltify.test',
                'password' => 'password',
                'is_admin' => false,
            ],
            [
                'name' => 'Miguel Santos',
                'email' => 'miguel@boltify.test',
                'password' => 'password',
                'is_admin' => false,
            ],
            [
                'name' => 'Andrea Reyes',
                'email' => 'andrea@boltify.test',
                'password' => 'password',
                'is_admin' => false,
            ],
            [
                'name' => 'Carlo Mendoza',
                'email' => 'carlo@boltify.test',
                'password' => 'password',
                'is_admin' => false,
            ],
            [
                'name' => 'Patricia Cruz',
                'email' => 'patricia@boltify.test',
                'password' => 'password',
                'is_admin' => false,
            ],
        ];

        foreach ($users as $attributes) {
            $user = User::query()->updateOrCreate(
                ['email' => $attributes['email']],
                $attributes,
            );

            $user->forceFill(['email_verified_at' => now()])->save();
        }
    }
}
