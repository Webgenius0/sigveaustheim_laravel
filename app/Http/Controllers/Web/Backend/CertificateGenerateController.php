<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Student;
use App\Traits\ApiResponse;
use Spatie\Browsershot\Browsershot;
use App\Http\Controllers\Controller;
use App\Http\Resources\studentDetailsResource;

class CertificateGenerateController extends Controller
{
    use ApiResponse;
    // generate certificate
    public function generateCertificate($id)
    {
        try {
            $student = Student::with(['school', 'creator', 'testScores.fitnessTest'])->find($id);

            if (!$student) {
                return $this->error([], 'Student not found.', 404);
            }

            $studentData = (new studentDetailsResource($student))->toArray(request());

            $html = view('certificate.certificate', compact('studentData'))->render();

            // Generate unique filename
            $fileName = 'certificate_' . str_replace(' ', '_', strtolower($student->name)) . '_' . now()->format('Ymd_His') . '.pdf';
            $path = storage_path('app/public/' . $fileName);


            Browsershot::html($html)
                ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe')
                ->margins(0, 0, 0, 0)
                ->format('A4')
                ->printBackground() // This enables background graphics
                ->showBackground()   // Alternative method for background images
                ->waitUntilNetworkIdle() // Wait for all resources to load
                ->timeout(60) // Increase timeout for image loading
                ->save($path);

            return response()->download($path);
        } catch (Exception $e) {
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
