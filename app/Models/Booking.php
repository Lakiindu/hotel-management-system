<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'guests',
        'special_requests',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    //Booking belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Booking belongs to one room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    //Booking has one payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    //Booking has one review
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}