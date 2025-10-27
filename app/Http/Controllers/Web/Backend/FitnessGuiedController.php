<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Helper\Helper;
use App\Models\TestGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FitnessGuiedController extends Controller
{
    //get upload test guied
    public function upload()
    {
        $testGuide = TestGuide::firstOrCreate();
        return view('backend.layouts.tests.guide', compact('testGuide'));
    }

    //upsert fitness guied
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guide_file_path' => 'nullable|mimes:pdf|max:10240',
        ]);


        DB::beginTransaction();

        try {
            // Check if a record already exists (assuming only one guide record)
            $testGuide = TestGuide::first();

            $filePath = $testGuide->guide_file_path ?? null;

            // Upload new file if provided
            if ($request->hasFile('guide_file_path')) {
                $filePath = Helper::fileUpload(
                    $request->file('guide_file_path'),
                    'test_guides',
                    $request->name ?? 'fitness-guide'
                );
            }

            // Update or create record
            $testGuide = TestGuide::updateOrCreate(
                ['id' => optional($testGuide)->id],
                [
                    'name' => $request->name,
                    'guide_file_path' => $filePath,
                ]
            );

            DB::commit();

            return redirect()->back()->with('success', 'Fitness Test Guide saved successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
