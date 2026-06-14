<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Service model represents the services table
class Service extends Model
{
    //Fields that can be inserted or updated
    protected $fillable = [
        'title',
        'description',
        'icon',
        'image',
        'is_active',
    ];

    // Automatically convert database values into PHP data types
    protected $casts = [
        'is_active' => 'boolean',
    ];
}