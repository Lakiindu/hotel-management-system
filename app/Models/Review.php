<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Review model represents the reviews table
class Review extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'booking_id',
        'rating',
        'comment',
    ];

    //Review belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    //Review belongs to one room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    //Review belongs to one booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}