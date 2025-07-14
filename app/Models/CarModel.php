<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'name', 'description', 'is_active'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function variants()
    {
        return $this->hasMany(CarVariant::class);
    }

    public function images()
    {
        return $this->hasMany(CarModelImage::class);
    }

    public function getMainImageUrlAttribute()
    {
        if ($this->main_image_path) {
            return asset('storage/' . $this->main_image_path);
        }
        $variantName = $this->name ?? 'Model';
        $encodedName = urlencode($variantName);
        return "https://via.placeholder.com/400x300/4f46e5/ffffff?text={$encodedName}";
    }

    public function getImageUrlAttribute()
    {
        // First check if there's a main image from the images relationship
        $mainImage = $this->images()->where('is_main', true)->first();
        if ($mainImage) {
            return $mainImage->image_url;
        }

        // If no main image, get the first image
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_url;
        }

        // Fall back to placeholder
        $variantName = $this->name ?? 'Model';
        $encodedName = urlencode($variantName);
        return "https://via.placeholder.com/400x300/4f46e5/ffffff?text={$encodedName}";
    }
}
