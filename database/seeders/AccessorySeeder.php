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
                'price' => 500,
            ],
            [
                'name' => 'All-Weather Interior Mats',
                'description' => 'Custom-fit mats for all Tesla models',
                'price' => 250,
            ],
            [
                'name' => 'Roof Rack',
                'description' => 'Aerodynamic roof rack for Model 3/Y',
                'price' => 400,
            ],
            [
                'name' => 'Car Cover',
                'description' => 'Outdoor car cover for Model S/X/3/Y',
                'price' => 350,
            ],
        ];

        foreach ($accessories as $item) {
            $product = Product::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'product_type' => 'accessory',
                'is_active' => true,
            ]);

            Accessory::create([
                'product_id' => $product->id,
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                // Nếu có các trường khác như image_path, is_active thì thêm vào đây
                'is_active' => true,
            ]);
        }
    }
}
