<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $adminUsers = User::where('role', 'admin')->get();

        if ($adminUsers->isEmpty()) {
            // Nếu chưa có admin nào, có thể tạo user admin mẫu ở đây hoặc bỏ qua
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            $admin = $adminUsers->random();
            $title = fake()->sentence(5, true);
            Blog::create([
                'admin_id' => $admin->id,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . uniqid(),
                'content' => fake()->paragraphs(3, true),
                'image_path' => 'https://picsum.photos/800/400?random=' . rand(1, 1000),
                'is_published' => fake()->boolean(80),
                'published_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
