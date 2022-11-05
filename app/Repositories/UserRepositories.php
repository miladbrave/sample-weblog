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

    public function getCurrentUser()
    {
        return auth("sanctum")->user();
    }

    public function makePassword($password)
    {
        return $this->query()->update([
            'password' => Hash::make($password)
        ]);
    }
}
