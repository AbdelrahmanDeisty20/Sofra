<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'image' => asset($this->image),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'restaurant_id' => (int) $this->restaurant_id,
        ];
    }
}
