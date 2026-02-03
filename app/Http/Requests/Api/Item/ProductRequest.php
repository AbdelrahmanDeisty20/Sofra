<?php

namespace App\Http\Requests\Api\Item;

use App\Http\Requests\Api\BaseRequest;

class ProductRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric',
            'details' => 'required',
            'ready' => 'required|boolean',
        ];
    }
}
