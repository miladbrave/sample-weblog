<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoriesInterface;
use App\Core\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;


class UserRepositories extends BaseRepository implements UserRepositoriesInterface
{
    public function model(): string
    {
        return User::class;
    }

    public function findUserByEmail($email)
    {
        return $this->query()->where('email',$email)->first();
    }

    public function createUser($data)
    {
        return $this->query()->create($data);
    }
}
