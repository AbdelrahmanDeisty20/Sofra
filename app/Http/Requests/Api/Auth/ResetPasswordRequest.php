<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseRequest;

class ResetPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required'
        ];
    }
}
