<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarVariant;
use App\Models\CarVariantColor;
use Illuminate\Support\Facades\DB;

class CarVariantColorSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing colors 
        CarVariantColor::query()->delete();

        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Fetch variants to get their IDs
        $variants = CarVariant::all();

        // Skip if no variants exist
        if ($variants->isEmpty()) {
            echo "No variants found. Please run CarVariantSeeder first.\n";
            return;
        }

        if ($variant = $variants->where('id', 1)->first() ?? $variants->first()) {
            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đỏ',
                'image_url' => 'https://i.pinimg.com/1200x/42/82/37/428237ad7f8581c887d716f82706c4f7.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Trắng',
                'image_url' => 'https://i.pinimg.com/1200x/61/cc/5a/61cc5a703a7482037976eb7a5a5246a1.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đen',
                'image_url' => 'https://i.pinimg.com/1200x/a5/14/87/a51487c378bb3569bc1b6d2b7208937c.jpg',
            ]);
        }

        if ($variant = $variants->where('id', 2)->first() ?? ($variants->count() > 1 ? $variants[1] : null)) {
            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đỏ',
                'image_url' => 'https://i.pinimg.com/1200x/f5/54/3b/f5543bf52648bfc0e0a855888abe4b78.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Trắng',
                'image_url' => 'https://i.pinimg.com/1200x/f2/b5/b3/f2b5b3f8932db9b79be789afda03ea28.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đen',
                'image_url' => 'https://i.pinimg.com/1200x/1b/1c/b5/1b1cb5a2e4d189abff0c599c1db10b41.jpg',
            ]);
        }

        if ($variant = $variants->where('id', 3)->first() ?? ($variants->count() > 2 ? $variants[2] : null)) {
            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đỏ',
                'image_url' => 'https://i.pinimg.com/1200x/eb/d5/ab/ebd5abd9644edb7cbf9c2f4614678f8f.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Trắng',
                'image_url' => 'https://i.pinimg.com/736x/06/4a/5e/064a5e6cd5760a47b1c4d14571578002.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đen',
                'image_url' => 'https://i.pinimg.com/736x/71/0c/4d/710c4d1213b46497c192b7717bdc0897.jpg',
            ]);
        }

        if ($variant = $variants->where('id', 4)->first() ?? ($variants->count() > 3 ? $variants[3] : null)) {
            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đỏ',
                'image_url' => 'https://i.pinimg.com/1200x/30/81/dc/3081dc48584ad864fbec756abd5b7353.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Trắng',
                'image_url' => 'https://i.pinimg.com/1200x/ed/eb/35/edeb350e026237bdf7d672f74c09d45e.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đen',
                'image_url' => 'https://i.pinimg.com/736x/e0/ce/39/e0ce39c24617c20935efd8093c240837.jpg',
            ]);
        }

        if ($variant = $variants->where('id', 5)->first() ?? ($variants->count() > 4 ? $variants[4] : null)) {
            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đỏ',
                'image_url' => 'https://i.pinimg.com/1200x/fc/ec/ed/fceced524d0166980431c5e4a258859c.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Trắng',
                'image_url' => 'https://i.pinimg.com/1200x/ad/49/83/ad49831ac904406d7ddda7981b54d244.jpg',
            ]);

            CarVariantColor::create([
                'car_variant_id' => $variant->id,
                'color_name' => 'Đen',
                'image_url' => 'https://i.pinimg.com/1200x/74/5c/36/745c36b7f36650f9f5e91af41dacf360.jpg',
            ]);
        }

        // // For any remaining variants, add a default color
        // foreach ($variants->where('id', '>', 8) as $variant) {
        //     // Determine variant type by name
        //     $name = strtolower($variant->name ?? '');
        //     $modelName = '';

        //     if ($variant->carModel) {
        //         $modelName = strtolower($variant->carModel->name ?? '');
        //     }

        //     // Add appropriate color based on variant type
        //     if (str_contains($name, 'suv') || str_contains($modelName, 'suv')) {
        //         CarVariantColor::create([
        //             'car_variant_id' => $variant->id,
        //             'color_name' => 'Đỏ',
        //             'image_url' => 'images/cars/colors/suv-red.jpg',
        //         ]);
        //     } else if (str_contains($name, 'sport') || str_contains($modelName, 'sport')) {
        //         CarVariantColor::create([
        //             'car_variant_id' => $variant->id,
        //             'color_name' => 'Đỏ',
        //             'image_url' => 'images/cars/colors/sport-red.jpg',
        //         ]);
        //     } else if (str_contains($name, 'luxury') || str_contains($modelName, 'luxury')) {
        //         CarVariantColor::create([
        //             'car_variant_id' => $variant->id,
        //             'color_name' => 'Đỏ',
        //             'image_url' => 'images/cars/colors/luxury-red.jpg',
        //         ]);
        //     } else {
        //         CarVariantColor::create([
        //             'car_variant_id' => $variant->id,
        //             'color_name' => 'Đỏ',
        //             'image_url' => 'images/cars/colors/sedan-red.jpg',
        //         ]);
        //     }
        // }
    }
}
