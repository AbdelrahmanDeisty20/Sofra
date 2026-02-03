<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseRequest;

class NewPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required',
            'pin_code' => 'required',
            'password' => 'required|confirmed'
        ];
    }
}
