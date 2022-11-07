<?php

namespace App\Http\Requests\v1\teacher;

use Illuminate\Foundation\Http\FormRequest;

class ToChangeRoleRequest extends FormRequest
{

    public function rules()
    {
        return [
            'user_id' => 'required|numeric'
        ];
    }
}
