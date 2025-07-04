<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'product_type',
        'reference_id',
        'is_active',
    ];

    public function carVariant()
    {
        return $this->belongsTo(CarVariant::class, 'reference_id');
    }

    public function accessory()
    {
        return $this->belongsTo(Accessory::class, 'reference_id');
    }

    public function getImageUrlAttribute()
    {
        if ($this->attributes['image_url']) {
            return asset('storage/' . $this->attributes['image_url']);
        }
        // Use placeholder images for demo
        return 'https://via.placeholder.com/300x200/10b981/ffffff?text=' . urlencode($this->name);
    }
}
