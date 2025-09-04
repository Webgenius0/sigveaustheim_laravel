<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'school' => [
                'id'   => $this->school->id,
                'name' => $this->school->name,
                'principal_name' => $this->school->principal_name,
                'email' => $this->school->email,
                'phone' => $this->school->phone,
                'street_address' => $this->school->street_address,
                'city' => $this->school->city,
                'state' => $this->school->state,
                'zip_code' => $this->school->zip_code,
                'approximate_student_count' => $this->school->approximate_student_count,
            ],

            'contact' => [
                'id' => $this->school->contacts->first()->id ?? null,
                'school_id' => $this->school->id,
                'name' => $this->school->contacts->first()->name ?? null,
                'email' => $this->school->contacts->first()->email ?? null,
                'phone' => $this->school->contacts->first()->phone ?? null,
                'role' => $this->school->contacts->first()->role ?? 'PE Teacher',
            ],

            'user' => [
                'id' => $this->id,
                'school_id' => $this->school_id,
                'username' => $this->username,
                'email' => $this->email,
                'role' => $this->role
            ],
        ];
    }
}
