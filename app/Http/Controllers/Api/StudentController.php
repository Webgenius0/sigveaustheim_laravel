<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Student;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    use ApiResponse;


    // get all student
    public function index(Request $request)
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->error([], 'User not found.', 404);
            }

            // Get per_page from request or default 10
            $perPage = $request->get('per_page', 10);

            $students = Student::with(['school', 'creator'])
                ->latest('id')
                ->paginate($perPage);

            // Format response
            $response = [
                'data'         => StudentResource::collection($students),
                'total'        => $students->total(),
                'current_page' => $students->currentPage(),
                'last_page'    => $students->lastPage(),
                'per_page'     => $students->perPage()
            ];

            return $this->success(
                $response,
                'Student list retrieved successfully.',
                200
            );
        } catch (Exception $e) {
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }


    // Show a specific student
    public function show($id)
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->error([], 'User not found.', 404);
            }

            $student = Student::with(['school', 'creator'])->find($id);
            if (!$student) {
                return $this->error([], 'Student not found.', 404);
            }

            return $this->success(
                new StudentResource($student),
                'Student retrieved successfully.',
                200
            );
        } catch (Exception $e) {
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    // Create a new student
    public function store(Request $request)
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->error([], 'User not found.', 404);
            }

            $validator = Validator::make($request->all(), [
                'name'          => 'required|string|max:255',
                'gender'        => 'required|string|in:male,female',
                'date_of_birth' => 'nullable|date',
                'class'         => 'nullable|string|max:50',
                'section'       => 'nullable|string|max:50',
                'class_roll'    => 'nullable|string|max:50',
            ]);

            if ($validator->fails()) {
                // ek line message format
                $errors = $validator->errors()->all();
                $message = $errors[0] ?? 'Validation failed.';
                if (count($errors) > 1) {
                    $message .= ' (and ' . (count($errors) - 1) . ' more errors)';
                }

                return $this->error([], $message, 422);
            }

            $validatedData = $validator->validated();

            $validatedData['school_id']  = $user->school->id;
            $validatedData['created_by'] = $user->id;

            // dd($validatedData);

            $student = Student::create($validatedData);

            return $this->success(
                new StudentResource($student),
                'Student created successfully.',
                201
            );
        } catch (Exception $e) {
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    // Update an existing student
    public function update(Request $request, $id)
    {
        try {
            $user = auth('api')->user();
            if (!$user) {
                return $this->error([], 'User not found.', 404);
            }

            $student = Student::find($id);
            if (!$student) {
                return $this->error([], 'Student not found.', 404);
            }

            $validator = Validator::make($request->all(), [
                'name'          => 'required|string|max:255',
                'gender'        => 'required|string|in:male,female',
                'date_of_birth' => 'nullable|date',
                'class'         => 'nullable|string|max:50',
                'section'       => 'nullable|string|max:50',
                'class_roll'    => 'nullable|string|max:50',
            ]);

            if ($validator->fails()) {
                // ek line message format
                $errors = $validator->errors()->all();
                $message = $errors[0] ?? 'Validation failed.';
                if (count($errors) > 1) {
                    $message .= ' (and ' . (count($errors) - 1) . ' more errors)';
                }

                return $this->error([], $message, 422);
            }

            $validatedData = $validator->validated();

            // update student
            $student->update($validatedData);

            return $this->success(
                new StudentResource($student),
                'Student updated successfully.',
                200
            );
        } catch (Exception $e) {
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    // Delete a student
    public function destroy($id)
    {
        try {
            $user = auth('api')->user();
            if (!$user) {
                return $this->error([], 'User not found.', 404);
            }

            $student = Student::find($id);
            if (!$student) {
                return $this->error([], 'Student not found.', 404);
            }

            $student->delete();

            return $this->success([], 'Student deleted successfully.', 200);
        } catch (Exception $e) {
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
