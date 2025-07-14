<?php

namespace App\Http\Controllers\User;

use App\Models\CarModel;
use App\Models\Accessory;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CarVariant;
use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy các hãng xe đang hoạt động
        $cars = Car::with('carModels')->get();
        // Lấy các mẫu xe đang hoạt động
        $carModels = CarModel::where('is_active', true)->get();

        // Lấy phụ kiện kèm sản phẩm
        $accessories = Accessory::with('product')
            ->where('is_active', 1)
            ->take(4)
            ->get();

        // Lấy 4 bài viết mới nhất
        $blogs = Blog::latest()->take(4)->get();

        $featuredCars = CarVariant::with('product', 'colors')->where('is_active', 1)->take(4)->get();
        // Lấy các phiên bản xe (CarVariant) nổi bật
        $featuredVariants = CarVariant::with('product')
            ->where('is_active', 1)
            ->take(4)
            ->get();

        $carModelImages = CarModel::with('images')->get();

        return view('user.home', compact(
            'cars',
            'carModels',
            'accessories',
            'blogs',
            'featuredVariants',
            'featuredCars',
            'carModelImages'
        ));
    }
}
