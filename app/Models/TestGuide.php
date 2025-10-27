<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestGuide extends Model
{
    protected $fillable = [
        "name",
        "guide_file_path"
    ];
}
