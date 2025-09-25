<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Student;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\studentDetailsResource;

class CertificateGenerateController extends Controller
{
    use ApiResponse;
    // generate certificate
    public function generateCertificate($id)
    {
        try {
            $student = Student::with(['school', 'creator', 'testScores.fitnessTest'])
                ->find($id);

            if (!$student) {
                return $this->error([], 'Student not found.', 404);
            }

            // Use the resource to prepare structured data
            $studentData = (new studentDetailsResource($student))->toArray(request());

            return view('certificate.certificate', compact('studentData'));
        } catch (Exception $e) {
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
