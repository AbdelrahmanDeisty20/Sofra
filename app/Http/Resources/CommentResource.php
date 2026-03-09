<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'rate' => $this->rate,
            'client' => new UserResource($this->whenLoaded('client')),
            'restaurant' => new UserResource($this->whenLoaded('restaurant')),
            'created_at' => $this->created_at,
        ];
    }
}
