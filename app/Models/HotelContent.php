<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// HotelContent model represents the hotel_contents table
class HotelContent extends Model
{
    //Fields that can be inserted or updated
    protected $fillable = [
        'section_key',
        'title',
        'content',
        'image',
        'is_active',
    ];

    // Automatically convert database values into PHP data types
    protected $casts = [
        'is_active' => 'boolean',
    ];
}