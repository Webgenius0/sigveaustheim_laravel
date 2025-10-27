<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Helper\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FitnessTestLevel;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class FitnessTestLevelController extends Controller
{
    // lsit of fitness test levels
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $levels = FitnessTestLevel::select('fitness_test_levels.*', 'fitness_tests.name as test_name')
                ->join('fitness_tests', 'fitness_test_levels.test_id', '=', 'fitness_tests.id')
                ->latest('fitness_test_levels.id')
                ->get();

            return DataTables::of($levels)
                ->addIndexColumn()
                ->addColumn('test_name', fn($row) => $row->test_name)
                ->addColumn('level_name', fn($row) => $row->level_name)
                ->addColumn('percentage_range', fn($row) => "{$row->min_percentage}% - {$row->max_percentage}%")
                ->addColumn('comment', fn($row) => Str::limit(strip_tags($row->comment), 50, '...'))
                ->addColumn('star_image', function ($row) {
                    return $row->star_image ? '<img src="' . asset('/' . $row->star_image) . '" alt="Star" width="40">' : '---';
                })

                ->addColumn('action', function ($row) {
                    return '<div class="d-flex justify-content-start align-items-center gap-1">
                        <button type="button"
                                class="btn btn-primary btn-sm editLevel"
                                data-id="' . $row->id . '">
                            <i class="fe fe-edit"></i>
                        </button>
                        <button type="button"
                                onclick="showDeleteConfirm(' . $row->id . ')"
                                class="btn btn-danger btn-sm">
                            <i class="fe fe-trash"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['star_image', 'action'])
                ->make(true);
        }

        return view('backend.layouts.tests.test_level');
    }

    // store fitness test level
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'test_id' => 'required|exists:fitness_tests,id',
            'level' => 'required|integer|between:1,5',
            'level_name' => 'required|string|max:50',
            'min_percentage' => 'required|integer|min:0|max:100',
            'max_percentage' => 'required|integer|min:0|max:100|gte:min_percentage',
            'comment' => 'nullable|string',
            'star_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // Check if this test already has 5 levels
            $existingLevelsCount = FitnessTestLevel::where('test_id', $request->test_id)->count();

            if ($existingLevelsCount >= 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more than 5 levels for a single test.',
                ], 422);
            }

            // Check unique test_id and level combination
            $exists = FitnessTestLevel::where('test_id', $request->test_id)
                ->where('level', $request->level)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This level already exists for the selected test.',
                ], 422);
            }

            // Handle image uploads
            if ($request->hasFile('star_image')) {
                $validatedData['star_image'] = Helper::uploadImage($request->file('star_image'), 'test/images');
            }

            FitnessTestLevel::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Fitness Test Level created successfully!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // edit fitness test level
    public function edit($id)
    {
        $level = FitnessTestLevel::findOrFail($id);
        return response()->json($level);
    }

    // update fitness test level
    public function update(Request $request, $id)
    {
        $level = FitnessTestLevel::find($id);
        if (!$level) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness Test Level not found.',
            ], 404);
        }

        $validatedData = $request->validate([
            'test_id' => 'required|exists:fitness_tests,id',
            'level' => 'required|integer|between:1,5',
            'level_name' => 'required|string|max:50',
            'min_percentage' => 'required|integer|min:0|max:100',
            'max_percentage' => 'required|integer|min:0|max:100|gte:min_percentage',
            'comment' => 'nullable|string',
            'star_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // Check unique test_id and level combination (excluding current record)
            $exists = FitnessTestLevel::where('test_id', $request->test_id)
                ->where('level', $request->level)
                ->where('id', '!=', $id)
                ->exists();
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This level already exists for the selected test.',
                ], 422);
            }

            // Handle image uploads
            if ($request->hasFile('star_image')) {
                if ($level->star_image) {
                    Helper::deleteImage($level->star_image);
                }
                $validatedData['star_image'] = Helper::uploadImage($request->file('star_image'), 'test/images');
            }

            $level->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Fitness Test Level updated successfully!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Fitness Test Level.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // delete fitness test level
    public function destroy($id)
    {
        $level = FitnessTestLevel::find($id);
        if (!$level) {
            return response()->json([
                'success' => false,
                'message' => 'Fitness Test Level not found.',
            ], 404);
        }

        try {
            if ($level->star_image) {
                Helper::deleteImage($level->star_image);
            }
            $level->delete();

            return response()->json([
                'success' => true,
                'message' => 'Fitness Test Level deleted successfully!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Fitness Test Level.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
