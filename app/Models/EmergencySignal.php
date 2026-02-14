<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencySignal extends Model
{
    protected $table = 'emergency_signals';

    protected $fillable = [
        'user_id',
        'signal_id',
        'signal_status',
        'latitude',
        'longitude',
    ];
}
