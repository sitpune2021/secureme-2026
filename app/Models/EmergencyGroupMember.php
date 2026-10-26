<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyGroupMember extends Model
{


    protected $table = 'emergency_group_members';

    protected $fillable = [
        'group_id',
        'user_id',
        'role',
        'status',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function group()
    {
        return $this->belongsTo(EmergencyGroup::class, 'group_id');
    }


}
