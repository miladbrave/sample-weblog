<?php

if (!function_exists("checkType")) {
    function checkType(string $email): ?string
    {
        if (checkValidateEmail($email))
            return "email";

        return null;
    }

    if (!function_exists("checkValidateEmail")) {
        function checkValidateEmail($email)
        {
            $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z0-9]+(\.)+[a-zA-Z]{2,3})$/";
            return preg_match($regex, $email);
        }
    }
}
