<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CarVariant;
use Illuminate\Http\Request;

class UserCarVariantController extends Controller
{
    public function show($id)
    {
        $variant = CarVariant::with('product', 'carModel')->findOrFail($id);
        return view('user.car_variants.show', compact('variant'));
    }
}