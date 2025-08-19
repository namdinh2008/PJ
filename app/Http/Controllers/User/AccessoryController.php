<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\Product;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function show($id)
    {
        $accessory = Accessory::with('product')->findOrFail($id);
        // Get related accessories (excluding the current one), limit to 8
        $accessories = Accessory::with('product')
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();
        return view('user.accessories.show', compact('accessory', 'accessories'));
    }
}
