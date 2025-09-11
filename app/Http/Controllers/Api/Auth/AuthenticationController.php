<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use App\Models\User;
use App\Models\School;
use App\Models\Contact;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Mail\SchoolRegisterSuccessForAdminMail;
use App\Mail\SchoolRegisterSuccessForTeacherMail;

class AuthenticationController extends Controller
{
    use ApiResponse;

    /*
    ** User registration
    */
    public function register(UserRegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();

            // Extra check: same contact email already linked to a school
            if (Contact::where('email', $validatedData['contact_email'])->exists()) {
                throw new Exception('This teacher/contact is already linked to a school.');
            }

            // Extra check: school name already taken
            if (School::where('name', $validatedData['school_name'])->exists()) {
                throw new Exception('This school name is already registered.');
            }

            // User create first
            $user = User::create([
                'username' => $validatedData['username'],
                'email' => $validatedData['contact_email'],
                'password' => bcrypt($validatedData['password']),
                'role' => 'teacher',
            ]);

            // Generate approval token
            $approvalToken = base64_encode(Str::random(40));

            // School create
            $school = School::create([
                'user_id' => $user->id,
                'name' => $validatedData['school_name'],
                'principal_name' => $validatedData['principal_name'],
                'email' => $validatedData['school_email'],
                'phone' => $validatedData['school_phone'],
                'street_address' => $validatedData['street_address'],
                'city' => $validatedData['city'],
                'state' => $validatedData['state'],
                'zip_code' => $validatedData['zip_code'],
                'approximate_student_count' => $validatedData['approximate_student_count'],
                'status' => 'pending',
                'approval_token' => $approvalToken,
            ]);

            // Contact create
            $contact = Contact::create([
                'school_id' => $school->id,
                'name' => $validatedData['contact_name'],
                'email' => $validatedData['contact_email'],
                'phone' => $validatedData['contact_phone'] ?? null,
                'role' => 'PE Teacher',
            ]);

            DB::commit();

            // Email part
            $approveUrl = route('admin.schools.approve', ['token' => $school->approval_token]);
            $cancelUrl = route('admin.schools.cancel', ['token' => $school->approval_token]);

            Mail::to('arifulislam6460@gmail.com')
                ->send(new SchoolRegisterSuccessForAdminMail($school, $approveUrl, $cancelUrl, $contact));

            Mail::to($contact->email)
                ->send(new SchoolRegisterSuccessForTeacherMail($contact, $school));

            return $this->success([
                'user'    => $user,
                'school'  => $school,
                'contact' => $contact,
            ], 'Registration successful. Pending admin approval.', 201);
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

            // Check role (must be teacher)
            if ($user->role !== 'teacher') {
                return $this->error([], 'Only teachers are allowed to login.', 403);
            }

            // Check if school is approved
            $school = School::where('user_id', $user->id)->first();
            if (!$school || $school->status !== 'approved') {
                return $this->error([], 'Your school is not approved yet.', 403);
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
                'school'   => [
                    'id'     => $school->id,
                    'name'   => $school->name,
                    'status' => $school->status,
                ],
                'token'    => $token,
            ];

            return $this->success($userData, 'Successfully logged in!', 200);
        } catch (Exception $e) {
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
