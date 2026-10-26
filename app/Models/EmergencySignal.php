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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function groups()
    {
        return $this->hasMany(
            EmergencyGroup::class,
            'signal_id',
            'id'
        );
    }

    public function responses()
    {
        return $this->hasMany(
            EmergencyResponse::class,
            'signal_id',
            'id'
        );
    }

    
}
