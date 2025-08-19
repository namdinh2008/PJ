<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarVariant;
use Illuminate\Support\Facades\DB;

class CarVariantOptionSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa toàn bộ dữ liệu cũ để tránh lặp
        DB::table('car_variant_options')->truncate();

        $variants = CarVariant::all();
        foreach ($variants as $variant) {
            DB::table('car_variant_options')->insert([
                [
                    'car_variant_id' => $variant->id,
                    'option_name' => 'Gói tự lái',
                    'option_value' => 'Full Self-Driving',
                    'price' => 200000,
                ],
                [
                    'car_variant_id' => $variant->id,
                    'option_name' => 'Nội thất cao cấp',
                    'option_value' => 'Da trắng',
                    'price' => 100000,
                ],
            ]);
        }
    }
}