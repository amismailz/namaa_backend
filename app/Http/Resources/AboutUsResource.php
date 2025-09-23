<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'images' => $this->image ? array_map(function ($image) {
                return url('storage/' . $image);
            }, $this->image) : [],
            'created_at' => $this->created_at,
        ];
    }
}
