<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'rate' => (int) $this->rate,
            'client_id' => (int) $this->client_id,
            'restaurant_id' => (int) $this->restaurant_id,
        ];
    }
}
