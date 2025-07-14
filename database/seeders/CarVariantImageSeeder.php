<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;
use App\Models\CarVariant;
use App\Models\CarVariantImage;

class CarVariantImageSeeder extends Seeder
{
    public function run(): void
    {
        CarVariantImage::create([
            'car_variant_id' => 1,
            'image_url' => asset('https://i.pinimg.com/736x/36/6e/55/366e55a87ff36966393fc2cc49cab6ce.jpg'),
            'is_main' => true,
        ]);

        CarVariantImage::create([
            'car_variant_id' => 1,
            'image_url' => asset('https://i.pinimg.com/1200x/48/5e/cf/485ecf39b8a3b5cb9e62247d89f8e5a6.jpg'),
            'is_main' => false,
        ]);

        CarVariantImage::create([
            'car_variant_id' => 2,
            'image_url' => asset('https://i.pinimg.com/1200x/c6/ff/5a/c6ff5ac8f057fd3abdcbeb332a7d4675.jpg'),
            'is_main' => true,
        ]);

        CarVariantImage::create([
            'car_variant_id' => 2,
            'image_url' => asset('https://i.pinimg.com/1200x/64/69/bd/6469bddcb1229f1d635f0b16835061eb.jpg'),
            'is_main' => false,
        ]);

        CarVariantImage::create([
            'car_variant_id' => 3,
            'image_url' => asset('https://i.pinimg.com/736x/1f/c9/c2/1fc9c210d2f6ab86f7b5afdaaf6a3204.jpg'),
            'is_main' => true,
        ]);

        CarVariantImage::create([
            'car_variant_id' => 3,
            'image_url' => asset('https://i.pinimg.com/1200x/ed/55/c9/ed55c9cc7c82e3346eb9b8ba50faac0f.jpg'),
            'is_main' => false,
        ]);

        CarVariantImage::create([
            'car_variant_id' => 4,
            'image_url' => asset('https://i.pinimg.com/1200x/de/7d/4a/de7d4acac5611e5502245170f8003038.jpg'),
            'is_main' => true,
        ]);

        CarVariantImage::create([
            'car_variant_id' => 4,
            'image_url' => asset('https://i.pinimg.com/1200x/83/9b/48/839b484571179ce72a3c1a0f3d9926aa.jpg'),
            'is_main' => false,
        ]);

        CarVariantImage::create([
            'car_variant_id' => 5,
            'image_url' => asset('https://i.pinimg.com/1200x/e1/ac/1d/e1ac1d56555db7dc30f809180c8c3982.jpg'),
            'is_main' => true,
        ]);

        CarVariantImage::create([
            'car_variant_id' => 5,
            'image_url' => asset('https://i.pinimg.com/1200x/f2/ef/45/f2ef4530716168eb37396920b76d1892.jpg'),
            'is_main' => false,
        ]);
    }
}
