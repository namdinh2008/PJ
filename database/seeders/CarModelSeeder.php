<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarModel;

class CarModelSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy danh sách cars để gán model tương ứng
        $cars = Car::all()->keyBy('name');

        $models = [
            [
                'car_id' => $cars['Tesla']->id ?? null,
                'name' => 'Model S',
                'description' => 'Electric sedan with high performance and long range.',
                'is_active' => true,
            ],
            [
                'car_id' => $cars['Tesla']->id ?? null,
                'name' => 'Model X',
                'description' => 'Luxury electric SUV with falcon wing doors.',
                'is_active' => true,
            ],
            [
                'car_id' => $cars['Toyota']->id ?? null,
                'name' => 'Corolla',
                'description' => 'Reliable and fuel-efficient compact sedan.',
                'is_active' => true,
            ],
            [
                'car_id' => $cars['BMW']->id ?? null,
                'name' => 'X5',
                'description' => 'Luxury mid-size SUV with premium features.',
                'is_active' => true,
            ],
            [
                'car_id' => $cars['Hyundai']->id ?? null,
                'name' => 'Elantra',
                'description' => 'Compact sedan with modern design and tech.',
                'is_active' => true,
            ],
        ];

        foreach ($models as $model) {
            if ($model['car_id']) {
                CarModel::create($model);
            }
        }
    }
}