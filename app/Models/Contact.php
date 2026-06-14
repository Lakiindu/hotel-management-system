<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Contact model represents the contacts table
class Contact extends Model
{
    //Fields that can be inserted or updated
    protected $fillable = [
    'name',
    'email',
    'phone',
    'subject',
    'message',
    'status',
];
}