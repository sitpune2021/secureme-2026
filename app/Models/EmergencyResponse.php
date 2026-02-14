<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyResponse extends Model
{
    protected $table = 'emergency_responses';
    protected $fillable = [
        'signal_id',
        'responder_type',
        'user_id',
        'response_action',
        'response_notes',
        'status'
    ];
}
