<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Room model represents the rooms table
class Room extends Model
{
    protected $fillable = [
        'room_number',
        'room_type',
        'price_per_night',
        'capacity',
        'description',
        'facilities',
        'image',
        'status',
    ];

    // Automatically convert database values into PHP data types
    protected $casts = [
        'facilities' => 'array',
        'price_per_night' => 'decimal:2',
    ];

    //Room can have many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    //Room can have many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}