<?php

namespace App\Http\Resources;

use App\Models\FitnessTests;
use App\Models\FitnessTestLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Load all fitness tests
        $allTests = FitnessTests::all();

        $fitnessTests = $allTests->map(function ($test) {
            $scores = $this->testScores->where('fitness_test_id', $test->id);
            $lastScore = $scores->sortByDesc('test_date')->first();

            $scoreValue = $lastScore?->score !== null ? (int) $lastScore->score : null;

            // Calculate level data for this test
            $levelData = $this->getTestLevelData($test->id, $scoreValue);

            return [
                'id' => $test->id,
                'name' => $test->name,
                'unit' => $lastScore?->unit,
                'is_completed' => $scores->isNotEmpty(),
                'attempts' => $scores->count(),
                'last_score' => $scoreValue,
                'out_of' => 10,
                'level' => $levelData['level'],
                'level_name' => $levelData['level_name'],
                'star_image' => $levelData['star_image'],
                'comment' => $levelData['comment'],
                'battery_image' => $this->getBatteryImage($scoreValue),
            ];
        });

        $totalLastScores = $fitnessTests->sum(fn($t) => $t['last_score'] ?? 0);
        $maxPossible = $fitnessTests->count() * 10;
        $overallPercentage = $maxPossible ? round(($totalLastScores / $maxPossible) * 100, 2) : 0;

        // Summary
        $uniqueTestsCount = $this->testScores
            ->pluck('fitness_test_id')
            ->unique()
            ->count();

        return [
            'student' => [
                'id' => $this->id,
                'name' => $this->name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'age' => $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null,
                'class' => $this->class,
                'section' => $this->section,
                'class_roll' => $this->class_roll,
                'school' => $this->whenLoaded('school', function () {
                    return [
                        'id' => $this->school->id,
                        'school_name' => $this->school->name,
                        'principal_name' => $this->school->principal_name,
                        'phone' => $this->school->phone ?? null,
                        'street_address' => $this->school->street_address ?? null,
                        'city' => $this->school->city,
                        'state' => $this->school->state,
                        'zip_code' => $this->school->zip_code,
                    ];
                }),
            ],

            'fitness_tests' => $fitnessTests,

            'summary' => [
                'total_attempts' => $this->testScores->count(),
                'unique_tests_taken' => $uniqueTestsCount,
                'overall_percentage' => $overallPercentage,
                'overall_level' => $this->getOverallLevel($overallPercentage),
                'overall_comment' => $this->getOverallComment($overallPercentage),
                'overall_image' => $this->getOverallImage($overallPercentage),
                'last_test_scores_sum' => $totalLastScores,
                'suggestion_for_improvement' => $this->getImprovementSuggestion($overallPercentage),
            ],
        ];
    }

    /**
     * Get level data based on score for individual test
     * Rule: 2 points = 1 level (0-2 = Level 1, 3-4 = Level 2, etc.)
     */
    private function getTestLevelData($testId, $score)
    {
        // Default response when no score
        if ($score === null || $score === 0) {
            return [
                'level' => null,
                'level_name' => null,
                'star_image' => null,
                'comment' => 'The student has not attempted this test yet.'
            ];
        }

        // Calculate percentage (score out of 10)
        $percentage = ($score / 10) * 100;

        // Find the matching level from database
        $testLevel = FitnessTestLevel::where('test_id', $testId)
            ->where('min_percentage', '<=', $percentage)
            ->where('max_percentage', '>=', $percentage)
            ->first();

        if ($testLevel) {
            return [
                'level' => $testLevel->level,
                'level_name' => $testLevel->level_name,
                'star_image' => $testLevel->star_image ? asset('/' . $testLevel->star_image) : null,
                'comment' => $testLevel->comment
            ];
        }

        // Fallback if no level found in database
        return [
            'level' => null,
            'level_name' => 'Not Defined',
            'star_image' => null,
            'comment' => 'Level not configured for this score range.'
        ];
    }

    /**
     * Get overall level based on percentage
     * Rule: Every 10% = 1 level (1-10% = Level 1, 11-20% = Level 2, ..., 91-100% = Level 10)
     */
    private function getOverallLevel($percentage)
    {
        if ($percentage == 0) {
            return 0;
        }

        // Calculate level: ceil to round up (1-10 = 1, 11-20 = 2, etc.)
        return (int) ceil($percentage / 10);
    }

    /**
     * Get overall image based on percentage range
     */
    private function getOverallImage($percentage)
    {
        $imagePath = null;

        if ($percentage >= 81 && $percentage <= 100) {
            $imagePath = '/stars/level5.jpg'; // Excellent - 81-100%
        } elseif ($percentage >= 61 && $percentage <= 80) {
            $imagePath = '/stars/level4.jpg'; // Very Good - 61-80%
        } elseif ($percentage >= 41 && $percentage <= 60) {
            $imagePath = '/stars/level3.jpg'; // Good - 41-60%
        } elseif ($percentage >= 21 && $percentage <= 40) {
            $imagePath = '/stars/level2.jpg'; // Limited - 21-40%
        } elseif ($percentage >= 1 && $percentage <= 20) {
            $imagePath = '/stars/level1.jpg'; // Low - 1-20%
        }

        return $imagePath ? asset('' . $imagePath) : null;
    }

    /**
     * Get overall comment based on overall percentage
     */
    private function getOverallComment($percentage)
    {
        if ($percentage >= 81 && $percentage <= 100) {
            return 'Maintains a structured exercise routine with dedication, and represents the pinnacle of physical fitness. Demonstrates an excellent fitness level overall. Excels in high-intensity activities and may compete at an elite level in sports or fitness competitions.';
        }

        if ($percentage >= 61 && $percentage <= 80) {
            return 'Adheres to a structured exercise regimen. Consistently engages in physical activity and exhibits a very good fitness level overall. Performs at a high level in various sports activities. Does well in high-intensity activities, and may engage in sports or fitness competitions.';
        }

        if ($percentage >= 41 && $percentage <= 60) {
            return 'Maintains a regular exercise routine and engages in regular physical activity. Demonstrates a good fitness level overall. Can perform daily tasks comfortably and participate in moderate to high-intensity physical activities without significant difficulty.';
        }

        if ($percentage >= 21 && $percentage <= 40) {
            return 'Engages inconsistently in physical activity. Exhibits limited fitness level overall. Performs daily tasks adequately but may struggle with more demanding activities. May participate in recreational sports or fitness classes but lacks endurance and stamina.';
        }

        // 1-20% or 0%
        return 'Demonstrates low levels of physical fitness. Leads a sedentary lifestyle and rarely engages in physical activity. Shows poor fitness level overall. Struggles with moderate physical tasks without significant effort and experiences fatigue quickly during activity.';
    }

    /**
     * Suggestion for improvement comments
     */
    private function getImprovementSuggestion($percentage)
    {
        if ($percentage >= 81 && $percentage <= 100) {
            return 'Maintain a lifelong commitment to physical fitness by embracing it as a lifestyle. Continue setting new goals and striving for improvement. Share your knowledge and passion for fitness with others to inspire and support their own journeys towards better health and fitness';
        }
        if ($percentage >= 61 && $percentage <= 80) {
            return 'Focus on mastering advanced exercise techniques and movements to improve efficiency and effectiveness. Refine form and technique to minimise injury. Test yourself with more complex movements or advanced exercise variations to continue progressing';
        }
        if ($percentage >= 41 && $percentage <= 60) {
            return 'Define clear, specific fitness goals based on desired outcomes such as improved endurance, strength, or flexibility. Break larger goals into smaller, actionable steps to create a roadmap for progress. Continue monitoring progress towards goals and adjust workouts accordingly';
        }
        if ($percentage >= 21 && $percentage <= 40) {
            return 'Aim to engage in physical activity consistently, aiming for at least 30 minutes most days of the week. Focus on finding activities you enjoy to make exercise more sustainable. Start tracking progress to monitor consistency and stay motivated';
        }
        // 1-20% or 0%
        return 'Begin by assessing current fitness levels and setting realistic goals. Commit to making small, manageable changes to daily habits. Start incorporating short bouts of physical activity into daily routine, such as walking or taking the stairs';
    }

    /**
     * Battery image
     */
    public function getBatteryImage($lastScore)
    {
        $batteryImage = null;

        if ($lastScore == 0) {
            $batteryImage = '/battery/battery0.png'; // for 0 point
        } elseif ($lastScore == 1) {
            $batteryImage = '/battery/battery1.png'; // for 1 point
        } elseif ($lastScore == 2) {
            $batteryImage = '/battery/battery2.png'; // for 2 point
        } elseif ($lastScore == 3) {
            $batteryImage = '/battery/battery3.png'; // for 3 point
        } elseif ($lastScore == 4) {
            $batteryImage = '/battery/battery4.png'; // for 4 point
        } elseif ($lastScore == 5) {
            $batteryImage = '/battery/battery5.png'; // for 5 point
        } elseif ($lastScore == 6) {
            $batteryImage = '/battery/battery6.png'; // for 6 point
        } elseif ($lastScore == 7) {
            $batteryImage = '/battery/battery7.png'; // for 7 point
        } elseif ($lastScore == 8) {
            $batteryImage = '/battery/battery8.png'; // for 8 point
        } elseif ($lastScore == 9) {
            $batteryImage = '/battery/battery9.png'; // for 9 point
        } elseif ($lastScore == 10) {
            $batteryImage = '/battery/battery10.png'; // for 10 point
        }

        return $batteryImage ? asset('' . $batteryImage) : null;
    }
}
