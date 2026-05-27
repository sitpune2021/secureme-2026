<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyAlert extends Model
{
    protected $fillable = [

        'user_name',
        'mobile',
        'message',
        'latitude',
        'longitude',
        'status'
    ];
}