<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModelImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_model_id',
        'image_url',
        'is_main',
    ];

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image_url ?? 'https://via.placeholder.com/400x300/1f2937/ffffff?text=Image';
    }
}