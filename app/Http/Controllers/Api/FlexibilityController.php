<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Models\TestScore;
use App\Traits\ApiResponse;
use App\Models\FitnessTests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\FlexibilityService;

class FlexibilityController extends Controller
{
     use ApiResponse;
    public function store(Request $request, FlexibilityService $flexibilityService)
    {
        $user = auth('api')->user();
        if (!$user) {
            return $this->error(null, 'Unauthorized', 401);
        }

        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'fitness_test_id' => 'required|exists:fitness_tests,id',
            'distance'        => 'required|numeric|min:0',
        ]);

        $student = Student::findOrFail($request->student_id);
        $test = FitnessTests::findOrFail($request->fitness_test_id);

        DB::transaction(function () use ($student, $test, $request, $flexibilityService, &$result) {
            $result = $flexibilityService->calculatePoints($student, $request->distance);

            TestScore::create([
                'student_id'      => $student->id,
                'fitness_test_id' => $test->id,
                'tested_by'       => auth()->id(),
                'score'           => $result['points'],
                'unit'             => 'cm',
                'test_date'       => now(),
            ]);
        });

        return $this->success($result, 'Test score saved successfully');
    }
}
