<?php

namespace App\Http\Resources\HomePage;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'image' => $this->image ? url(path: 'storage/' . $this->image) : null,
            'short_description' => $this->short_description,
            // 'description' => $this->description,
            // 'meta_title' => $this->meta_title,
            // 'meta_description' => $this->meta_description,
            // 'is_popular' => $this->is_popular,
            // 'published_date' => $this->published_date,
            // 'faqs' => FaqResource::collection($this->faqs),
            //   'created_at' => $this->created_at->format('Y-m-d H:i:s'),

        ];
    }
}
