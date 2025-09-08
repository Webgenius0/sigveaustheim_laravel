<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Models\TestScore;
use App\Models\FitnessTests;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\FitnessService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FitnessScoreController extends Controller
{
    use ApiResponse;
    public function store(Request $request, FitnessService $fitnessService)
    {
        $user = auth('api')->user();
        if (!$user) {
            return $this->error(null, 'Unauthorized', 401);
        }

        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'fitness_test_id' => 'required|exists:fitness_tests,id',
            'duration'        => 'required|numeric|min:0',
        ]);

        $student = Student::findOrFail($request->student_id);
        // dd($request->$student);
        $test = FitnessTests::findOrFail($request->fitness_test_id);

        DB::transaction(function () use ($student, $test, $request, $fitnessService, &$result) {
            $result = $fitnessService->calculatePoints($student, $request->duration);

            TestScore::create([
                'student_id'      => $student->id,
                'fitness_test_id' => $test->id,
                'tested_by'       => auth()->id(),
                'score'           => $result['points'],
                'duration'        => $request->duration,
                'test_date'       => now(),
            ]);
        });


        return $this->success($result, 'Test score saved successfully');
    }
}
