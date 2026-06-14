<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Gallery model represents the galleries table
class Gallery extends Model
{
    //Fields that can be inserted or updated
    protected $fillable = [
        'title',
        'image',
        'category',
        'description',
        'is_active',
    ];

    // Automatically convert database values into PHP data types
    protected $casts = [
        'is_active' => 'boolean',
    ];
}