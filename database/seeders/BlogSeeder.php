<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $adminUsers = User::where('is_admin', true)->get();

        for ($i = 0; $i < 10; $i++) {
            $admin = $adminUsers->random();

            Blog::create([
                'admin_id' => $admin->id,
                'title' => fake()->sentence(6, true),
                'content' => fake()->paragraphs(3, true),
                'image_url' => fake()->imageUrl(640, 480, 'car', true, 'Tesla'),
                'is_published' => fake()->boolean(80),
                'published_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}