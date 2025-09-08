<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponse;
use App\Models\FitnessTests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FitnessTestController extends Controller
{
    use ApiResponse;

    public function index()
    {
        // Logic to retrieve and return a list of fitness tests
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->error([], 'User not found.', 404);
            }

            $tests = FitnessTests::select('id','name')->get();

            return $this->success(
                $tests,
                'Test list retrieved successfully.',
                200
            );
        } catch (Exception $e) {
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }


    public function show($id)
    {
        // Logic to retrieve and return a specific fitness test by its ID
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->error([], 'User not found.', 404);
            }

            $test = FitnessTests::find($id);

            if (!$test) {
                return $this->error([], 'Test not found.', 404);
            }

            return $this->success(
                $test,
                'Test details retrieved successfully.',
                200
            );
        } catch (Exception $e) {
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
