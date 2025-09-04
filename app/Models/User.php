<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, Billable;

    protected $fillable = [
        'school_id',
        'username',
        'password',
        'role',
        'email',
        'avatar',
        'otp',
        'is_otp_verified',
        'otp_expires_at',
        'reset_password_token',
        'reset_password_token_expire_at',
    ];


    protected $casts = [
        'is_otp_verified' => 'boolean',
        'otp_expires_at' => 'datetime',
        'reset_password_token_expire_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    //relation with school table
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
