<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class RestaurantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'minimum_order' => (float) $this->minimum_order,
            'delivery_fees' => (float) $this->delivery_fees,
            'image' => asset($this->image),
            'whatsapp' => $this->whatsapp,
            'status' => (int) $this->status,
            'region_id' => (int) $this->region_id,
            'region' => new RegionResource($this->whenLoaded('region')),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
