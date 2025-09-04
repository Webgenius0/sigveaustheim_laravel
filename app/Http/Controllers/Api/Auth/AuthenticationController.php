<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\School;
use App\Models\Contact;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\OtpVerifyRequest;
use App\Http\Requests\Auth\UserRegisterRequest;

class AuthenticationController extends Controller
{
    use ApiResponse;

    /*
    ** User registration
    */
    public function register(UserRegisterRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();

            // School create
            $school = School::create([
                'name' => $validatedData['school_name'],
                'principal_name' => $validatedData['principal_name'],
                'email' => $validatedData['school_email'],
                'phone' => $validatedData['school_phone'],
                'street_address' => $validatedData['street_address'],
                'city' => $validatedData['city'],
                'state' => $validatedData['state'],
                'zip_code' => $validatedData['zip_code'],
                'approximate_student_count' => $validatedData['approximate_student_count'],
            ]);

            // Contact create
            $contact = Contact::create([
                'school_id' => $school->id,
                'name' => $validatedData['contact_name'],
                'email' => $validatedData['contact_email'],
                'phone' => $validatedData['contact_phone'] ?? null,
                'role' => 'PE Teacher',
            ]);

            // User create
            $user = User::create([
                'school_id' => $school->id,
                'username' => $validatedData['username'],
                'email' => $validatedData['contact_email'], // same as contact email
                'password' => bcrypt($validatedData['password']),
                'role' => 'user',
            ]);

            DB::commit();

            return $this->success(
                [
                    'school' => $school,
                    'contact' => $contact,
                    'user' => $user,
                ],
                'Registration successful.',
                201
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error([], 'Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /*
    ** User login
    */
    public function login(LoginRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Find user by username
            $user = User::where('username', $validatedData['username'])->first();

            if (!$user) {
                return $this->error([], 'Invalid username or password.', 401);
            }

            // Auth attempt with username + password
            if (!($token = auth('api')->attempt([
                'username' => $validatedData['username'],
                'password' => $validatedData['password'],
            ]))) {
                return $this->error([], 'Invalid username or password.', 401);
            }

            $userData = [
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
                'role'     => $user->role,
                'token'    => $token,
            ];

            return $this->success($userData, 'Successfully logged in!', 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->error([], $e->getMessage(), 500);
        }
    }


    /*
    ** User logout
    */
    public function logout()
    {
        try {

            auth('api')->logout();
            return $this->success([], 'Successfully logged out.', 200);
        } catch (Exception $e) {

            Log::info($e->getMessage());
            return $this->error([], $e->getMessage(), 500);
        }
    }
}
