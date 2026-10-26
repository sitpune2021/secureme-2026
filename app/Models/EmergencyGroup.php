<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyGroup extends Model
{

    protected $table = 'emergency_groups';

    protected $fillable = [
        'signal_id',
        'group_name',
    ];

    public function signal()
    {
        return $this->belongsTo(
            EmergencySignal::class,
            'signal_id',
            'id'
        );
    }

    public function members()
    {
        return $this->hasMany(
            EmergencyGroupMember::class,
            'group_id',
            'id'
        );
    }


}
