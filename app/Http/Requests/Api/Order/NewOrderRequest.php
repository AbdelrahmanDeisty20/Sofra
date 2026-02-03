<?php

namespace App\Http\Requests\Api\Order;

use App\Http\Requests\Api\BaseRequest;

class NewOrderRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'restaurant_id' => 'required|exists:users,id',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'address' => 'required',
            'payment_method' => 'required|in:1,2'
        ];
    }
}
