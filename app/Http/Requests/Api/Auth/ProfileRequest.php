<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseRequest;

class ProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        $user = $this->user();
        return [
            'email' => 'unique:users,email,' . $user->id,
            'password' => 'confirmed',
            'region_id' => 'exists:regions,id'
        ];
    }
}
