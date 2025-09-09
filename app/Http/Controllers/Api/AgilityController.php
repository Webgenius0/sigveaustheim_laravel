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

class AgilityController extends Controller
{
    use ApiResponse;
    public function store(Request $request, AgilityService $agilityService)
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
        $test = FitnessTests::findOrFail($request->fitness_test_id);

        DB::transaction(function () use ($student, $test, $request, $agilityService, &$result) {
            $result = $agilityService->calculatePoints($student, $request->duration);

            TestScore::create([
                'student_id'      => $student->id,
                'fitness_test_id' => $test->id,
                'tested_by'       => auth()->id(),
                'score'           => $result['points'],
                'unit'        => 'seconds',
                'test_date'       => now(),
            ]);
        });


        return $this->success($result, 'Test score saved successfully');
    }
}
