<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $paymentMethods = ['cod', 'bank_transfer', 'vnpay', 'momo'];
        $statuses = ['pending', 'confirmed', 'shipping', 'delivered', 'cancelled'];

        for ($i = 0; $i < 10; $i++) {
            $user = User::inRandomOrder()->first();
            
            Order::create([
                'user_id' => $user ? $user->id : null,
                'phone' => fake()->phoneNumber(),
                'name' => $user ? $user->name : fake()->name(),
                'email' => $user ? $user->email : fake()->safeEmail(),
                'address' => fake()->address(),
                'total_price' => fake()->randomFloat(2, 5000000, 100000000),
                'note' => fake()->optional()->sentence(),
                'payment_method' => fake()->randomElement($paymentMethods),
                'status' => fake()->randomElement($statuses),
            ]);
        }
    }
}