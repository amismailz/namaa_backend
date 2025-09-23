<?php

namespace App\Http\Resources;

use App\Models\Society;
use Illuminate\Http\Resources\Json\JsonResource;

class HostingPlanResource extends JsonResource
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
            'id'             => $this->id,
            'name'           => $this->name,
            'slug'           => $this->slug,
            'description'    => $this->description,
            'price'          => $this->price,
            'currency'       => $this->currency,
            'billing_cycle'  => $this->billing_cycle,
            // 'email_accounts' => $this->email_accounts,
            // 'storage'        => $this->storage,
            // 'bandwidth'      => $this->bandwidth,
            'free_domain'    => (bool) $this->free_domain,
            'is_most_popular' => (bool) $this->is_most_popular,
            // 'service_id'     => $this->service_id,
            // 'service'        => $this->service,
            'created_at'     => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'     => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
