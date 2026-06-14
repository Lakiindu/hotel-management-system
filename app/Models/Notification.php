<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Notification Model
// Handles all system notifications such as bookings,contact messages,alerts and status updates.
class Notification extends Model
{
    // Mass assignable fields that can be inserted/updated
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'url',
        'is_read',
    ];

    // Relationship:
    // Each notification belongs to a single user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}