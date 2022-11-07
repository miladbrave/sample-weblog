<?php

namespace App\Repositories\Interfaces;

use App\Core\Repositories\BaseRepositoryInterface;

interface UserRepositoriesInterface extends BaseRepositoryInterface
{
    public function findUserByEmail($email);

    public function createUser($data);
}
