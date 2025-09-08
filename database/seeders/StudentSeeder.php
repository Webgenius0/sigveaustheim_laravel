<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['name' => 'Ethan Carter',     'gender' => 'male',   'date_of_birth' => '2010-05-12 00:00:00', 'class' => '8', 'section' => 'A'],
            ['name' => 'Sophia Mitchell',  'gender' => 'female', 'date_of_birth' => '2011-03-20 00:00:00', 'class' => '7', 'section' => 'B'],
            ['name' => 'Liam Anderson',    'gender' => 'male',   'date_of_birth' => '2009-11-08 00:00:00', 'class' => '9', 'section' => 'A'],
            ['name' => 'Olivia Bennett',   'gender' => 'female', 'date_of_birth' => '2012-01-15 00:00:00', 'class' => '6', 'section' => 'C'],
            ['name' => 'Noah Williams',    'gender' => 'male',   'date_of_birth' => '2010-07-25 00:00:00', 'class' => '8', 'section' => 'B'],
            ['name' => 'Emma Johnson',     'gender' => 'female', 'date_of_birth' => '2009-09-02 00:00:00', 'class' => '9', 'section' => 'C'],
            ['name' => 'James Parker',     'gender' => 'male',   'date_of_birth' => '2011-12-10 00:00:00', 'class' => '7', 'section' => 'A'],
            ['name' => 'Ava Thompson',     'gender' => 'female', 'date_of_birth' => '2010-04-18 00:00:00', 'class' => '8', 'section' => 'C'],
            ['name' => 'William Harris',   'gender' => 'male',   'date_of_birth' => '2012-06-05 00:00:00', 'class' => '6', 'section' => 'B'],
            ['name' => 'Isabella Martinez', 'gender' => 'female', 'date_of_birth' => '2009-10-30 00:00:00', 'class' => '9', 'section' => 'A'],
        ];

        foreach ($students as &$student) {
            $student['school_id'] = 1;
            $student['created_by'] = 2;
            $student['created_at'] = Carbon::now();
            $student['updated_at'] = Carbon::now();
        }

        Student::insert($students);
    }
}
