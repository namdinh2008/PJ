<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'phone' => '0123456789',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        if (!User::where('email', 'user@example.com')->exists()) {
            User::create([
                'name' => 'User',
                'email' => 'user@example.com',
                'phone' => '0987654321',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        $this->call([
            CarSeeder::class,
            CarModelSeeder::class,
            AccessorySeeder::class,
            ProductSeeder::class,
            CarVariantSeeder::class,
            CarVariantColorSeeder::class,
            CarVariantImageSeeder::class,
            CarVariantOptionSeeder::class,
            OrderSeeder::class,
            BlogSeeder::class,
            CarModelImageSeeder::class,
        ]);
    }
}
