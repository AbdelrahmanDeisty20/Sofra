<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProductResource extends JsonResource
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
            'price' => (float) $this->price,
            'offer_price' => (float) $this->offer_price,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'ready' => (bool) $this->ready,
            'stock' => $this->stock,
            'restaurant_id' => $this->restaurant_id,
            'restaurant' => new UserResource($this->whenLoaded('restaurant')),
            'created_at' => $this->created_at,
        ];
    }
}
