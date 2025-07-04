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

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        // Use placeholder images for demo
        return 'https://via.placeholder.com/400x300/1f2937/ffffff?text=' . urlencode($this->name);
    }
}