<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CarVariant;
use Illuminate\Http\Request;

class UserCarVariantController extends Controller
{
    public function show($id)
    {
        $variant = CarVariant::with(['product', 'carModel.car', 'images', 'colors'])->findOrFail($id);

        // Get related variants from the same car model, excluding the current variant
        $relatedVariants = CarVariant::with(['product', 'colors', 'images'])
            ->where('car_model_id', $variant->car_model_id)
            ->where('id', '!=', $variant->id)
            ->limit(4)
            ->get();

        // If not enough related variants from same model, get from other models
        if ($relatedVariants->count() < 4) {
            $additionalVariants = CarVariant::with(['product', 'colors', 'images'])
                ->where('car_model_id', '!=', $variant->car_model_id)
                ->limit(4 - $relatedVariants->count())
                ->get();

            $relatedVariants = $relatedVariants->merge($additionalVariants);
        }

        return view('user.car_variants.show', compact('variant', 'relatedVariants'));
    }
}