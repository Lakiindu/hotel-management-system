<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //Fields that can be inserted or updated 
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'payment_date',
    ];

    // Automatically convert database values into PHP data types
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    //Payment belongs to one booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}