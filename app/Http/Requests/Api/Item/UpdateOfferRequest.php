<?php

namespace App\Http\Requests\Api\Item;

use App\Http\Requests\Api\BaseRequest;

class UpdateOfferRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'offer_id' => 'required|exists:offers,id',
            'name' => 'sometimes|required',
            'details' => 'sometimes|required',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after:start_time',
        ];
    }
}
