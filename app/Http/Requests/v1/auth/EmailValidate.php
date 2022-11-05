<?php

namespace App\Http\Requests\v1\auth;

use Illuminate\Validation\ValidationException;

trait EmailValidate
{
    public function checkType()
    {
        $type = checkType($this->input('username'));
        if (!$type)
            throw ValidationException::withMessages(['email' => 'invalid date']);

        return $type;
    }

    public function getRule($username):array
    {
        if ($username)
            return ['username' => 'required|email'];
    }
}
