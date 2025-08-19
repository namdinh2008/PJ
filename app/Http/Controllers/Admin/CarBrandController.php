<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    public function index()
    {
        $carBrands = CarBrand::query()
            ->distinct()
            ->get();

        return view('admin.car_brands.index', compact('carBrands'));
    }
}