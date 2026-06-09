<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelContent extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'content',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}