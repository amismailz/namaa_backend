<?php

namespace App\Http\Resources\NavBar;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class OurServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
        ];
    }
}
