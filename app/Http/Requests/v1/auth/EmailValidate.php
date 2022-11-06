<?php

namespace App\Http\Requests\v1\auth;

use Illuminate\Validation\ValidationException;

trait EmailValidate
{
    public function checkType()
    {
        $type = checkEmail($this->input('email'));
        if (!$type)
            throw ValidationException::withMessages(['email' => 'invalid date']);

        return $type;
    }

    public function getRule($username):array
    {
        if ($username)
            return ['email' => 'required|email'];
    }
}
