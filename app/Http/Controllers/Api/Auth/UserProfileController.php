<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use App\Models\User;
use App\Helper\Helper;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class UserProfileController extends Controller
{
    use ApiResponse;

    //get user progile
    public function profile()
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->error([], 'User not found.', 404);
            }

            // load school & contacts
            $user->load(['school', 'school.contacts']);

            return $this->success(
                new UserResource($user),
                'User profile retrieved successfully.',
                200
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }


    // update profile
    public function updateProfile(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = auth('api')->user();

            if (!$user) {
                return $this->error([], 'User not found.', 404);
            }

            // validation
            $validatedData = $request->validate([
                // school
                'school_name' => 'sometimes|string|max:255',
                'principal_name' => 'sometimes|string|max:255',
                'school_email' => 'sometimes|email|max:100|unique:schools,email,' . $user->school_id,
                'school_phone' => 'sometimes|string|max:20',
                'street_address' => 'sometimes|string|max:255',
                'city' => 'sometimes|string|max:100',
                'state' => 'sometimes|string|max:100',
                'zip_code' => 'sometimes|string|max:20',
                'approximate_student_count' => 'nullable|integer',

                // contact
                'contact_name' => 'sometimes|string|max:255',
                'contact_email' => 'sometimes|email|max:100',
                'contact_phone' => 'nullable|string|max:20',
            ]);

            // update school
            if ($user->school) {
                $user->school->update([
                    'name' => $validatedData['school_name'] ?? $user->school->name,
                    'principal_name' => $validatedData['principal_name'] ?? $user->school->principal_name,
                    'email' => $validatedData['school_email'] ?? $user->school->email,
                    'phone' => $validatedData['school_phone'] ?? $user->school->phone,
                    'street_address' => $validatedData['street_address'] ?? $user->school->street_address,
                    'city' => $validatedData['city'] ?? $user->school->city,
                    'state' => $validatedData['state'] ?? $user->school->state,
                    'zip_code' => $validatedData['zip_code'] ?? $user->school->zip_code,
                    'approximate_student_count' => $validatedData['approximate_student_count'] ?? $user->school->approximate_student_count,
                ]);
            }

            // update contact
            $contact = $user->school->contacts()->first();
            if ($contact) {
                $contact->update([
                    'name' => $validatedData['contact_name'] ?? $contact->name,
                    'email' => $validatedData['contact_email'] ?? $contact->email,
                    'phone' => $validatedData['contact_phone'] ?? $contact->phone,
                ]);
            }


            if (!empty($validatedData['contact_email'])) {
                $user->update([
                    'email' => $validatedData['contact_email'],
                ]);
            }

            DB::commit();

            return $this->success(
                new UserResource($user->fresh()->load(['school', 'school.contacts'])),
                'Profile updated successfully.',
                200
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }


    // update avatar
    public function updateAvatar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'avatar' => ['required', 'image', 'max:5120'],
            ]);


            if ($validator->fails()) {
                return $this->error([], $validator->errors()->first(), 422);
            }

            $user = auth('api')->user();

            if ($user->avatar) {
                Helper::deleteImage($user->avatar);
            }

            $avatarPath = Helper::uploadImage($request->file('avatar'), 'profile');

            $user->update(['avatar' => $avatarPath]);

            return $this->success(['avatar' => url($avatarPath)], 'Avatar updated successfully.', 200);
        } catch (Exception $e) {
            Log::error('Avatar Update Error: ' . $e->getMessage());
            return $this->error([], $e->getMessage(), 500);
        }
    }
}
