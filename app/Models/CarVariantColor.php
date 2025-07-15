<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarVariantColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_variant_id',
        'color_name',
        'image_url',
    ];

    public function variant()
    {
        return $this->belongsTo(CarVariant::class, 'car_variant_id');
    }

    public function getImageUrlAttribute()
    {
        if ($this->attributes['image_url']) {
            // Check if it's already a full URL (starts with http or https)
            if (filter_var($this->attributes['image_url'], FILTER_VALIDATE_URL)) {
                return $this->attributes['image_url'];
            }
            // Otherwise, assume it's a local file path and prepend the storage path
            return asset('storage/' . $this->attributes['image_url']);
        }
        return 'https://via.placeholder.com/100x100/cccccc/ffffff?text=Color';
    }
}
