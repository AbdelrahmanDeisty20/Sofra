<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'payment_method' => $this->payment_method,
            'state' => $this->state,
            'note' => $this->note,
            'delivery_charge' => (float) $this->delivery_charge,
            'commission' => (float) $this->commission,
            'total_price' => (float) $this->total_price,
            'net' => (float) $this->net,
            'restaurant' => new RestaurantResource($this->whenLoaded('restaurant')),
            'client' => new ClientResource($this->whenLoaded('client')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
