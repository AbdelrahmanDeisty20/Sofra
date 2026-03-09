<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;  // Added this use statement for UserResource
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'restaurant_id' => $this->restaurant_id,
            'restaurant' => new UserResource($this->whenLoaded('restaurant')),
            'created_at' => $this->created_at,
        ];
    }
}
