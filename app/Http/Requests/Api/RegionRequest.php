<?php

namespace App\Http\Requests\Api;

class RegionRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'city_id' => 'required|exists:cities,id'
        ];
    }
}
