<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Helper\Helper;
use Illuminate\Support\Str;
use App\Models\FitnessTests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class FitnessTestManageController extends Controller
{

    // list of all tests
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tests = FitnessTests::latest('id')->get();

            return DataTables::of($tests)
                ->addIndexColumn()
                ->addColumn('name', fn($row) => $row->name)
                ->addColumn('description', fn($row) => Str::limit(strip_tags($row->description), 120, '...'))
                ->addColumn('scoring_type', fn($row) => $row->scoring_type ?? '---')
                ->addColumn('image', function ($row) {
                    if ($row->image_path) {
                        return '<img src="' . asset($row->image_path) . '" alt="' . $row->name . '" width="80">';
                    }
                    return '---';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="d-flex justify-content-start align-items-center gap-1">
                   <button type="button"
                            class="btn btn-primary btn-sm editTest"
                            data-id="' . $row->id . '">
                        <i class="fe fe-edit"></i>
                    </button>

                    <button type="button" onclick="showDeleteConfirm(' . $row->id . ')" class="btn btn-danger btn-sm">
                        <i class="fe fe-trash"></i>
                    </button>
                </div>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('backend.layouts.tests.index');
    }


    // store test
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:100|unique:fitness_tests,name',
            'description'   => 'nullable|string',
            'scoring_type'  => 'nullable|in:time,distance,count,reps,score,level',
            'image_path'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // Handle image upload if provided
            if ($request->hasFile('image_path')) {
                $validatedData['image_path'] = Helper::uploadImage($request->file('image_path'), 'test/images');
            }

            FitnessTests::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Fitness Test created successfully!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Edit test
    public function edit($id)
    {
        try {
            $test = FitnessTests::find($id);

            if (!$test) {
                return response()->json(['success' => false, 'message' => 'Test not found.'], 404);
            }

            return response()->json(['success' => true, 'data' => $test]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch test. ' . $e->getMessage()]);
        }
    }

    // update test
    public function update(Request $request, $id)
    {
        $test = FitnessTests::find($id);
        if (!$test) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness Test not found.'
            ], 404);
        }

        $validatedData = $request->validate([
            'name'          => 'required|string|max:100|unique:fitness_tests,name,' . $test->id,
            'description'   => 'nullable|string',
            'scoring_type'  => 'nullable|in:time,distance,count,reps,score,level',
            'image_path'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // Handle image upload if provided
            if ($request->hasFile('image_path')) {
                // Delete old image
                if ($test->image_path) {
                    Helper::deleteImage($test->image_path);
                }
                $validatedData['image_path'] = Helper::uploadImage($request->file('image_path'), 'test/images');
            }

            $test->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Fitness Test updated successfully!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Fitness Test.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // delete test
    public function destroy($id)
    {
        $test = FitnessTests::find($id);
        if (!$test) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness Test not found.'
            ], 404);
        }

        try {
            // Delete image if exists
            if ($test->image_path) {
                Helper::deleteImage($test->image_path);
            }

            $test->delete();

            return response()->json([
                'success' => true,
                'message' => 'Fitness Test deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Fitness Test.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
