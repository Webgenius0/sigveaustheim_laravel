<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'gender'       => $this->gender,
            'age'          => $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null,
            'class'        => $this->class,
            'section'      => $this->section,
            'created_by'   => $this->creator ? $this->creator->username : null,
            'school'       => $this->whenLoaded('school', function () {
                return [
                    'id'             => $this->school->id,
                    'name'           => $this->school->name,
                ];
            }),
        ];
    }
}
