<?php

namespace App\Http\Requests\Api;

class RestaurantRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'restaurant_id' => 'required|exists:users,id,type,restaurant'
        ];
    }
}
