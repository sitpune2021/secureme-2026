<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [

        'community_id',
        'name',
        'email',
        'phone_no',
        'profile_image',
        'password',
        'user_role',
        'otp',
        'otp_expires_at',
        'is_available',
        'latitude',
        'longitude',
        'is_active',
        'last_location_update',
        'fcm_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $casts = [

        'otp_expires_at' => 'datetime',
        'last_location_update' => 'datetime',
        'email_verified_at' => 'datetime',

        'is_active' => 'boolean',
        'is_available' => 'boolean',

        'latitude' => 'float',
        'longitude' => 'float',
    ];

}
