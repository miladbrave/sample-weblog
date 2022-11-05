<?php

namespace App\Http\Requests\v1\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    use EmailValidate;

    public function rules()
    {
        $email = $this->checkType();
        $rule = $this->getRule($email);

        return array_merge($rule,[
            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])/',
            'name'          => 'required|string|min:3|max:156',
        ]);
    }
}
