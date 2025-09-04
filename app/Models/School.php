<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'principal_name',
        'email',
        'phone',
        'street_address',
        'city',
        'state',
        'zip_code',
        'approximate_student_count',
    ];


    //relation with contact table
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }


    //relation with user table
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
