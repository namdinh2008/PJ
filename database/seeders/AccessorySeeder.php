<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accessory;
use App\Models\Product;

class AccessorySeeder extends Seeder
{
    public function run(): void
    {
        $accessories = [
            [
                'name' => 'Wall Connector',
                'description' => 'Tesla Wall Connector for home charging',
                'price' => 500000,
                'image_path' => 'https://i.pinimg.com/736x/29/24/3b/29243b8079e6c6cabc28fa680eeb72bf.jpg',
            ],
            [
                'name' => 'All-Weather Interior Mats',
                'description' => 'Custom-fit mats for all Tesla models',
                'price' => 250000,
                'image_path' => 'https://i.pinimg.com/1200x/32/5d/af/325daf65daa745c9e43eb33014f4998d.jpg',
            ],
            [
                'name' => 'Roof Rack',
                'description' => 'Aerodynamic roof rack for Model 3/Y',
                'price' => 400000,
                'image_path' => 'https://i.pinimg.com/1200x/37/6f/8a/376f8a043882fbd8ed264868797d4910.jpg',
            ],
            [
                'name' => 'Car Cover',
                'description' => 'Outdoor car cover for Model S/X/3/Y',
                'price' => 350000,
                'image_path' => 'https://i.pinimg.com/1200x/01/b5/9c/01b59cdcd38f88d297af60bfd5c9337b.jpg',
            ],
        ];

        foreach ($accessories as $item) {
            $product = Product::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'product_type' => 'accessory',
                'image_url' => $item['image_path'], // Changed from image_path to img_url
                'is_active' => true,
            ]);

            Accessory::create([
                'product_id' => $product->id,
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'image_path' => $item['image_path'],
                'is_active' => true,
            ]);
        }
    }
}
