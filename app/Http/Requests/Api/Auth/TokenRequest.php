<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseRequest;

class TokenRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required'
        ];
    }
}
