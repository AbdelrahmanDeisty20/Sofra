<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'facebook_link' => $this->facebook_link,
            'whatsapp' => $this->whatsapp,
            'instagram_link' => $this->instagram_link,
            'email' => $this->email,
            'twitter_link' => $this->twitter_link,
            'youtube_link' => $this->youtube_link,
            'banks' => $this->banks,
            'commission_details' => $this->commission_details,
        ];
    }
}
