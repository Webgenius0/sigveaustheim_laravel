<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'description',
        'social_icons',
        'help_center_pdf',
        'privacy_policy_pdf',
        'email',
        'phone'
    ];

    protected $casts = [
        'social_icons' => 'array',
    ];
}
