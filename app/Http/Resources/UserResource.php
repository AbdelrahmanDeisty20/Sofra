<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
            'status' => (bool) $this->status,
            'region' => new StreetResource($this->whenLoaded('region')),
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            // Restaurant specific
            $this->mergeWhen($this->type === \App\Enums\UserType::RESTAURANT, [
                'minimum_order' => $this->minimum_order,
                'delivery_fees' => $this->delivery_fees,
                'whatsapp' => $this->whatsapp,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
