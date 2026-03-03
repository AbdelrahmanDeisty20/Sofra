<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'price' => (float) $this->price,
            'offer_price' => (float) $this->offer_price,
            'image' => asset($this->image),
            'ready' => (bool) $this->ready,
            'restaurant_id' => (int) $this->restaurant_id,
        ];
    }
}
