<?php

namespace App\Http\Requests\Api\Item;

use App\Http\Requests\Api\BaseRequest;

class UpdateProductRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'name' => 'sometimes|required',
            'price' => 'sometimes|required|numeric',
            'details' => 'sometimes|required',
            'ready' => 'sometimes|required|boolean',
        ];
    }
}
