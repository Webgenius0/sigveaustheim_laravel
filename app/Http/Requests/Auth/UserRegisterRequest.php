<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // School Info
            'school_name' => ['required', 'string', 'max:100'],
            'principal_name' => ['required', 'string', 'max:100'],
            'school_email' => ['required', 'string', 'email', 'max:100', 'unique:schools,email'],
            'school_phone' => ['required', 'string', 'max:20'],
            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'string', 'max:20'],
            'approximate_student_count' => ['nullable', 'integer', 'min:1'],

            // Contact Info
            'contact_name' => ['required', 'string', 'max:100'],
            'contact_email' => ['required', 'string', 'email', 'max:100'],
            'contact_phone' => ['nullable', 'string', 'max:20'],

            // User Info
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'school_name.required' => 'School name is required.',
            'principal_name.required' => 'Principal name is required.',
            'school_email.unique' => 'This school email is already registered.',
            'username.unique' => 'This username is already taken.',
            'password.confirmed' => 'Passwords do not match.',
        ];
    }
}
