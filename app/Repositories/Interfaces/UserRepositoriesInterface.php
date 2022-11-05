<?php

namespace App\Repositories\Interfaces;

interface UserRepositoriesInterface
{
    public function findUserByEmail($email);
}
