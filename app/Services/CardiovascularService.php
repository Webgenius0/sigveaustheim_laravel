<?php

namespace App\Services;

use App\Helper\Helper;
use App\Models\CardiovascularTestRule;
use App\Models\Student;

class CardiovascularService
{
    /**
     * Create a new class instance.
     */


    public function __construct()
    {
        //

    }

    public function calculatePoints(Student $student, $test_score)
    {
        // Calculate age using helper method
        $age = Helper::calculateAge($student->date_of_birth);


        // Find matching rule
        $rule = CardiovascularTestRule::where('gender', $student->gender)
            ->where('age', $age)
            ->where('min_duration', '<=', $test_score)
            ->where('max_duration', '>=', $test_score)
            ->first();

            return($rule);exit();

        if (!$rule) {
            return [
                'points' => 0,
                'comment' => 'No matching rule found',
            ];
        }

        return [
            'name' => $student->name,
            'age' => $age,
            'gender' => $student->gender,
            'points' => $rule->points,
            'duration' => $test_score,
            'comment' => "Scored {$rule->points} points in {$test_score} VO2 Max",
        ];
    }
}
