<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Models\TestScore;
use App\Models\FitnessTests;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\AgilityService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\StrengthService;

class StrengthController extends Controller
{
    use ApiResponse;
    public function store(Request $request, StrengthService $strengthService)
    {
        $user = auth('api')->user();
        if (!$user) {
            return $this->error(null, 'Unauthorized', 401);
        }

        // Check if user's school exists and is approved
        $school = $user->school;
        if (!$school || $school->status !== 'approved') {
            return $this->error(null, 'Your school is not approved. You cannot perform this test.', 403);
        }

        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'fitness_test_id' => 'required|exists:fitness_tests,id',
            'count'        => 'required|numeric',
        ]);

        $student = Student::findOrFail($request->student_id);
        $test = FitnessTests::findOrFail($request->fitness_test_id);

        DB::transaction(function () use ($student, $test, $request, $strengthService, &$result) {
            $result = $strengthService->calculatePoints($student, $request->count);

            TestScore::create([
                'student_id'      => $student->id,
                'fitness_test_id' => $test->id,
                'tested_by'       => auth()->id(),
                'score'           => $result['points'],
                'data'            => $request->duration,
                'unit'            => 'count',
                'test_date'       => now(),
            ]);
        });

        return $this->success($result, 'Test score saved successfully');
    }
}
