<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedBackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'rating'  => $this->rating,
            'comment' => $this->comment,
            'avatar'  => $this->user?->avatar,
            'contact' => $this->user?->school?->contact ? [
                'id'        => $this->user->school->contact->id,
                'name'      => $this->user->school->contact->name,
                'role'      => $this->user->school->contact->role,
            ] : null,
        ];
    }
}
