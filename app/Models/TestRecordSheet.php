<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestRecordSheet extends Model
{
    protected $fillable = [
        'fitness_test_id',
        'name',
        'sheet_url'
    ];

    // relation
    public function fitnessTest()
    {
        return $this->belongsTo(FitnessTests::class);
    }
}
