<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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

            'id'              => $this->id,
            'title'           => $this->title,
            'slug'            => $this->slug,
            'category' => new CategoryResource($this->category),
            'sub_category' => new SubCategoryResource($this->subCategory),
            'destination'     => $this->destination,
            'duration'        => $this->duration,
            'price'           => $this->price,
            'currency'        => $this->currency,
            'images' => $this->images ? array_map(function ($image) {
                return url('storage/' . $image);
            }, $this->images) : [],
            'description'     => $this->description,
            'map_link'        => $this->map_link,
            'rating'          => $this->rating,
            'is_popular'      => $this->is_popular,
            'is_best_offer'     => $this->is_best_offer,
            'created_at'      => $this->created_at?->format('Y-m-d H:i:s'),

        ];
    }
}
