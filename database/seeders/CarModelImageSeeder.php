<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarModelImage;
use Illuminate\Database\Seeder;

class CarModelImageSeeder extends Seeder
{
    public function run(): void
    {
        CarModelImage::create([
            'car_model_id' => 1,
            'image_url' => asset('https://i.pinimg.com/1200x/3c/80/62/3c8062c8a41e46dd6b32833d1615d344.jpg'),
            'is_main' => true,
        ]);

        CarModelImage::create([
            'car_model_id' => 1,
            'image_url' => asset('https://i.pinimg.com/1200x/d8/43/8a/d8438ac2206ca4f7c57aa59a1adaa5fc.jpg'),
            'is_main' => false,
        ]);

        CarModelImage::create([
            'car_model_id' => 2,
            'image_url' => asset('https://i.pinimg.com/736x/26/a4/03/26a4030315c7e41b20550665b45dcd67.jpg'),
            'is_main' => true,
        ]);

        CarModelImage::create([
            'car_model_id' => 2,
            'image_url' => asset('https://i.pinimg.com/736x/3f/a5/55/3fa55549d77d96f7d33baabf6626f592.jpg'),
            'is_main' => false,
        ]);

        CarModelImage::create([
            'car_model_id' => 3,
            'image_url' => asset('https://i.pinimg.com/1200x/e1/ce/4f/e1ce4fac3ce9a99a2a57fcbfc09c9897.jpg'),
            'is_main' => true,
        ]);

        CarModelImage::create([
            'car_model_id' => 3,
            'image_url' => asset('https://i.pinimg.com/1200x/55/93/36/55933653696277a208d42d9de10a04c4.jpg'),
            'is_main' => false,
        ]);

        CarModelImage::create([
            'car_model_id' => 4,
            'image_url' => asset('https://i.pinimg.com/736x/68/1e/44/681e44de3803edaf05bba75046759429.jpg'),
            'is_main' => true,
        ]);

        CarModelImage::create([
            'car_model_id' => 4,
            'image_url' => asset('https://i.pinimg.com/736x/b8/9b/53/b89b53aab238d2edee03fec82a893d10.jpg'),
            'is_main' => false,
        ]);

        CarModelImage::create([
            'car_model_id' => 5,
            'image_url' => asset('https://i.pinimg.com/736x/37/f3/b6/37f3b6c9a21657865f638c948b52d5aa.jpg'),
            'is_main' => true,
        ]);

        CarModelImage::create([
            'car_model_id' => 5,
            'image_url' => asset('https://i.pinimg.com/736x/02/30/84/02308401ab882136fee28b8251c4f786.jpg'),
            'is_main' => false,
        ]);
    }
}
