<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'phone' => 'required',
            'region_id' => 'required|exists:regions,id',
            'type' => 'required|in:client,restaurant'
        ];
    }
}
