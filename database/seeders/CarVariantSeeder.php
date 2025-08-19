<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarModel;
use App\Models\CarVariant;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CarVariantSeeder extends Seeder
{
    public function run(): void
    {
    // Xóa dữ liệu các bảng con trước, rồi mới xóa car_variants
    DB::table('car_variant_colors')->delete();
    DB::table('car_variant_images')->delete();
    DB::table('car_variant_options')->delete();
    DB::table('products')->where('product_type', 'car_variant')->delete();
    DB::table('car_variants')->delete();

        $carModels = CarModel::all()->keyBy('name');

        $variants = [
            [
                'car_model_id' => $carModels['Model S']->id ?? null,
                'name' => 'Model S Long Range',
                'description' => 'Dual Motor All-Wheel Drive, long range battery.',
                'features' => json_encode(['AWD', 'Autopilot', 'Long Range']),
                'price' => 799900000,
                'is_active' => true,
            ],
            [
                'car_model_id' => $carModels['Model X']->id ?? null,
                'name' => 'Model X Plaid',
                'description' => 'Three electric motors for insane performance.',
                'features' => json_encode(['Tri-Motor', 'Falcon Doors', 'Autopilot']),
                'price' => 899900000,
                'is_active' => true,
            ],
            [
                'car_model_id' => $carModels['Corolla']->id ?? null,
                'name' => 'Corolla Altis',
                'description' => 'Efficient engine with Toyota Safety Sense.',
                'features' => json_encode(['CVT', 'Lane Assist', 'Airbags']),
                'price' => 250000000,
                'is_active' => true,
            ],
            [
                'car_model_id' => $carModels['X5']->id ?? null,
                'name' => 'BMW X5 xDrive40i',
                'description' => 'Luxury SUV with turbocharged inline-6.',
                'features' => json_encode(['xDrive', 'Panoramic Roof', 'Heated Seats']),
                'price' => 610000000,
                'is_active' => true,
            ],
            [
                'car_model_id' => $carModels['Elantra']->id ?? null,
                'name' => 'Elantra Sport',
                'description' => 'Sporty trim with aggressive styling.',
                'features' => json_encode(['Turbocharged', 'Sport Seats']),
                'price' => 220000000,
                'is_active' => true,
            ],
        ];

        foreach ($variants as $variant) {
            if ($variant['car_model_id']) {
                $carVariant = CarVariant::create($variant);

                // Tạo Product liên kết với CarVariant này
                Product::create([
                    'name' => $carVariant->name,
                    'description' => $carVariant->description,
                    'price' => $carVariant->price,
                    'product_type' => 'car_variant',
                    'reference_id' => $carVariant->id,
                    'is_active' => true,
                ]);
            }
        }
    }
}
