<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyGroupMember extends Model
{
    protected $fillable = [
        'group_id',
        'user_id',
        'role',
        'status',
        'joined_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(EmergencyGroup::class);
    }
}
