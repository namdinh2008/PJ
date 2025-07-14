<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'content',
        'image_path',
        'is_published',
        'published_at',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
