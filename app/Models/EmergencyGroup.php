<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyGroup extends Model
{
    protected $fillable = [
        'owner_id',
        'group_name',
        'group_type',
        'description',
        'is_active'
    ];

    public function members()
    {
        return $this->hasMany(EmergencyGroupMember::class, 'group_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
