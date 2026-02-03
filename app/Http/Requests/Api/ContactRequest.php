<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\BaseRequest;

class ContactRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'full_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'content' => 'required',
            'type' => 'required'
        ];
    }
}
