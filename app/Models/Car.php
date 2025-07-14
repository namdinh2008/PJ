<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo_path',
        'country',
        'description',
    ];

    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo_path) {
            // Check if it's an external URL (starts with http)
            if (filter_var($this->logo_path, FILTER_VALIDATE_URL)) {
                return $this->logo_path;
            }
            // If it's a local file path, check if file exists before returning
            $fullPath = storage_path('app/public/' . $this->logo_path);
            if (file_exists($fullPath)) {
                return asset('storage/' . $this->logo_path);
            }
        }
        // Use placeholder images for demo
        $logos = [
            'Tesla' => 'images/logos/tesla.png',
            'BMW' => 'images/logos/bmw.png',
            'Toyota' => 'images/logos/toyota.png',
            'Hyundai' => 'images/logos/hyundai.png'
        ];

        // Return specific logo if available
        if (isset($logos[$this->name])) {
            return $logos[$this->name];
        }

        // Generate placeholder with proper encoding
        $carName = $this->name ?? 'Car';
        $encodedName = str_replace(' ', '+', $carName);

        return "https://placehold.co/200x200/4f46e5/ffffff?text={$encodedName}";
    }
}