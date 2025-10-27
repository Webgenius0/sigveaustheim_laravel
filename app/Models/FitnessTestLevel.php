<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessTestLevel extends Model
{
    // fillable properties
    protected $fillable = [
        'test_id',
        'level',
        'level_name',
        'min_percentage',
        'max_percentage',
        'comment',
        'star_image',
    ];
}
