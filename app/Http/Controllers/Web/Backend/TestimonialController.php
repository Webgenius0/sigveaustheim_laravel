<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\FeedBack;

class TestimonialController extends Controller
{
    // list of all feeddbacks
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FeedBack::with('user.school.contact')
                ->latest('id')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()

                // User name column
                ->addColumn('name', function ($data) {
                    return $data->user->school->contact->name ?? 'N/A';
                })

                // Avatar column
                ->addColumn('avatar', function ($data) {
                    $avatarPath = $data->user?->avatar ? asset($data->user->avatar) : asset('default/default_person.jpg');
                    return '<img src="' . $avatarPath . '" alt="image" width="50px" height="50px" style="margin-left:20px; border-radius:50%;">';
                })

                // Status column (switch button)
                ->addColumn('status', function ($data) {
                    $isActive = $data->status == 1;
                    $backgroundColor = $isActive ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $isActive ? '26px' : '2px';

                    $sliderStyles = "position: absolute; top: 2px; left: 2px;
                                 width: 20px; height: 20px; background-color: white;
                                 border-radius: 50%; transition: transform 0.3s ease;
                                 transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="statusChange(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;" ' . ($isActive ? 'checked' : '') . '>';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })

                // Action column
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                          <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                            <i class="fa fa-trash"></i>
                          </a>
                        </div>';
                })

                ->rawColumns(['avatar', 'status', 'action'])
                ->make(true);
        }

        return view('backend.layouts.testimonial.index');
    }


    public function status(int $id): JsonResponse
    {
        $data = FeedBack::findOrFail($id);
        $data->status = $data->status === 1 ? 0 : 1;
        $data->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status changed successfully!',
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $data = FeedBack::findOrFail($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Testimonial not found.',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully!',
        ], 200);
    }
}
