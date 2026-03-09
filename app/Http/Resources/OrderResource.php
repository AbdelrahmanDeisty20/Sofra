<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OrderResource extends JsonResource
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
            'state' => $this->state,
            'total_price' => (float) $this->total_price,
            'net' => (float) $this->net,
            'restaurant' => new RestaurantResource($this->whenLoaded('restaurant')),
            'client' => new ClientResource($this->whenLoaded('client')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
