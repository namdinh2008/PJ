<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    public function run(): void
    {
    // Xóa dữ liệu cũ để tránh lặp (xóa car_models trước, rồi cars)
    DB::table('car_models')->delete();
    DB::table('cars')->delete();
        $cars = [
            [
                'name' => 'Tesla',
                'logo_path' => 'images/logos/tesla.png',
                'country' => 'USA',
                'description' => 'Tesla is an American electric vehicle and clean energy company.',
            ],
            [
                'name' => 'Toyota',
                'logo_path' => 'images/logos/toyota.png',
                'country' => 'Japan',
                'description' => 'Toyota is one of the largest automobile manufacturers in the world.',
            ],
            [
                'name' => 'BMW',
                'logo_path' => 'images/logos/bmw.png',
                'country' => 'Germany',
                'description' => 'BMW is a German multinational company which produces luxury vehicles.',
            ],
            [
                'name' => 'Hyundai',
                'logo_path' => 'images/logos/hyundai.png',
                'country' => 'South Korea',
                'description' => 'Hyundai is a South Korean multinational automotive manufacturer.',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}