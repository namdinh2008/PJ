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
            return asset('storage/' . $this->logo_path);
        }
        // Use placeholder images for demo
        $logos = [
            'Tesla' => 'https://upload.wikimedia.org/wikipedia/commons/e/e8/Tesla_logo.png',
            'BMW' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/BMW.svg',
            'Mercedes' => 'https://upload.wikimedia.org/wikipedia/commons/9/90/Mercedes-Logo.svg',
            'Audi' => 'https://upload.wikimedia.org/wikipedia/commons/9/92/Audi-Logo_2016.svg'
        ];
        return $logos[$this->name] ?? 'https://via.placeholder.com/200x200/4f46e5/ffffff?text=' . urlencode($this->name);
    }
}