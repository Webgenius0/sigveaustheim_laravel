<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCertificate extends Model
{
    protected $fillable = [
        'student_id',
        'certificate_path',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
