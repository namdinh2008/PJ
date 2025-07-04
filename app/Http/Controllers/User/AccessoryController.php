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
        
        return view('user.accessories.show', compact('accessory'));
    }
} 