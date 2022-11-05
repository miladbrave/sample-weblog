<?php

namespace App\Repositories\Interfaces;

interface UserRepositoriesInterface
{
    public function findUserByEmail($email);

    public function getCurrentUser();

    public function makePassword($password);
}
