<?php

namespace App\Http\Requests\Api\Item;

use App\Http\Requests\Api\BaseRequest;

class OfferRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'details' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ];
    }
}
