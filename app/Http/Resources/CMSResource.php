<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CMSResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'page'          => $this->page,
            'section'       => $this->section,
            'name'          => $this->name,
            'title'         => $this->title,
            'description'   => $this->description,
            'image'         => asset($this->image),
        ];
    }
}
