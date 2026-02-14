<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyGroup extends Model
{
    protected $fillable = [
        'signal_id',
        'group_name',
    ];
}
