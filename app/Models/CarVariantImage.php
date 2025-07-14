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
        if ($this->attributes['image_url']) {
            // Check if it's an external URL (starts with http)
            if (filter_var($this->attributes['image_url'], FILTER_VALIDATE_URL)) {
                return $this->attributes['image_url'];
            }
            // If it's a local file path, prepend storage path
            return asset('storage/' . $this->attributes['image_url']);
        }
        return 'https://via.placeholder.com/400x300/4f46e5/ffffff?text=Image';
    }
}
