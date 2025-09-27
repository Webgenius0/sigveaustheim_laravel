<?php

namespace App\Http\Resources;

use App\Models\FitnessTests;
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

            return [
                'id' => $test->id,
                'name' => $test->name,
                'unit' => $lastScore?->unit,
                'is_completed' => $scores->isNotEmpty(),
                'attempts' => $scores->count(),
                'last_score' => $scoreValue,
                'out_of' => 10,
                'comment' => $this->getScoreComment($scoreValue)
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
                'age'          => $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null,
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
                'total_attempts'      => $this->testScores->count(),
                'unique_tests_taken'  => $uniqueTestsCount,
                'overall_percentage'  => $overallPercentage,
                'overall_comment'     => $this->getOverallComment($overallPercentage),
                'last_test_scores_sum' => $totalLastScores,
                // 'certificate_link' => route('certificate.generate', ['id' => $this->id]),
            ],
        ];
    }

    // For individual test
    private function getScoreComment($score)
    {
        if ($score === null || $score === 0) {
            return 'The student has not attempted this test yet.';
        }

        return match ($score) {
            1 => 'Needs significant improvement; focus on basics and practice regularly.',
            2 => 'Below average performance; more effort and training are required.',
            3 => 'Slightly below expectations; student should continue practicing to improve.',
            4 => 'Average performance; some improvement is still needed in certain areas.',
            5 => 'Fair performance; consistent effort will yield better results over time.',
            6 => 'Good performance; student demonstrates solid understanding and capability.',
            7 => 'Very good performance; shows dedication and noticeable improvement.',
            8 => 'Excellent performance; skills are well-developed and above average.',
            9 => 'Outstanding performance; student shows remarkable skill and proficiency.',
            10 => 'Perfect score; exceptional achievement, demonstrates mastery of this test.',
            default => 'Score data unavailable or invalid.'
        };
    }



    // For overall %
    private function getOverallComment($percentage)
    {
        if ($percentage < 50) return 'Needs Improvement';
        if ($percentage < 80) return 'Good Effort';
        if ($percentage < 95) return 'Excellent';
        return 'Outstanding Performance';
    }
}
