<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseRequest;

class RegisterTokenRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required',
            'platform' => 'required|in:android,ios'
        ];
    }
}
