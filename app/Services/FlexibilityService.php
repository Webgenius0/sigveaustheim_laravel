<?php

namespace App\Services;

use DateTime;
use App\Models\Student;
use App\Models\FlexibilityTestRule;

class FlexibilityService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function calculatePoints(Student $student, $distance)
    {
        // Calculate age using helper method
        $age = $this->calculateAge($student->date_of_birth);
        // return $age;exit();

        // Find matching rule
        $rule = FlexibilityTestRule::where('gender', $student->gender)
            ->where('age', $age)
            ->where('min_distance', '<=', $distance)
            ->where('max_distance', '>=', $distance)
            ->first();

        // return $rule;exit();

        if (!$rule) {
            return [
                'points' => 0,
                'comment' => 'No matching rule found',
            ];
        }

        return [
            'points' => $rule->points,
            'comment' => "Scored {$rule->points} points for {$distance} cm",
        ];
    }

    /**
     * Helper function to calculate age from date_of_birth
     */
    private function calculateAge($date_of_birth): int
    {
        if (!$date_of_birth) {
            return 0;
        }

        $dob = new DateTime($date_of_birth);
        $now = new DateTime();
        return $now->diff($dob)->y;
    }
}
