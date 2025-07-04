<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarVariantImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_variant_id',
        'image_url',
        'is_main',
    ];

    public function variant()
    {
        return $this->belongsTo(CarVariant::class, 'car_variant_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image_url ?? 'https://via.placeholder.com/400x300/4f46e5/ffffff?text=Image';
    }
}