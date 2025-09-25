<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\FeedBack;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedBackResource;

class FeedBackController extends Controller
{
    use ApiResponse;

    // Get all reviews for a specific venue
    public function index()
    {
        try {
            $reviews = FeedBack::with('user.school.contact')
                ->where('status', 1)
                ->latest('id')
                ->get();


            return $this->success(
                FeedBackResource::collection($reviews),
                'FeedBack retrieved successfully.',
                200
            );
        } catch (Exception $e) {
            return $this->error([], 'Failed to fetch reviews. ' . $e->getMessage(), 500);
        }
    }


    // Add or Update (Upsert) a review
    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return $this->error([], 'Unauthorized.', 401);
            }

            // Validation
            $request->validate([
                'rating'  => 'required|numeric|min:0|max:5',
                'comment' => 'nullable|string|max:500',
            ]);

            // updateOrCreate feedback
            $feedback = FeedBack::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'rating'  => $request->rating,
                    'comment' => $request->comment,
                    'status'  => 0,
                ]
            );

            return $this->success(
                new FeedBackResource($feedback),
                'Feedback submitted successfully. Awaiting admin approval.',
                201
            );
        } catch (Exception $e) {
            return $this->error([], 'Failed to submit feedback. ' . $e->getMessage(), 500);
        }
    }

    // Delete review
    public function destroy($id)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return $this->error([], 'Unauthorized.', 401);
            }

            $feedback = FeedBack::findOrFail($id);

            // Check: only owner or admin can delete
            if ($feedback->user_id !== $user->id && $user->role !== 'admin') {
                return $this->error([], 'You are not allowed to delete this feedback.', 403);
            }

            $feedback->delete();

            return $this->success([], 'Feedback deleted successfully.', 200);
        } catch (Exception $e) {
            return $this->error([], 'Failed to delete feedback. ' . $e->getMessage(), 500);
        }
    }
}
