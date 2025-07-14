<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'description',
        'price',
        'image_path',
        'is_active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
