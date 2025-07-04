<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_model_id',
        'name',
        'description',
        'features',
        'price',
        'is_active',
    ];

    public function colors()
    {
        return $this->hasMany(CarVariantColor::class, 'car_variant_id');
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function images()
    {
        return $this->hasMany(CarVariantImage::class);
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'reference_id', 'id');
    }

    public function getMainImageUrlAttribute()
    {
        if ($this->main_image_path) {
            return asset('storage/' . $this->main_image_path);
        }
        // Use placeholder images for demo
        return 'https://via.placeholder.com/400x300/4f46e5/ffffff?text=' . urlencode($this->name);
    }
}
