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
            // Check if it's an external URL (starts with http)
            if (filter_var($this->attributes['image_url'], FILTER_VALIDATE_URL)) {
                return $this->attributes['image_url'];
            }
            // If it's a local file path, prepend storage path
            return asset('storage/' . $this->attributes['image_url']);
        }
        // Use placeholder images for demo
        $productName = $this->name ?? 'Product';
        $encodedName = urlencode($productName);
        return "https://via.placeholder.com/300x200/10b981/ffffff?text={$encodedName}";
    }
}
