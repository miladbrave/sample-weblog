<?php

namespace App\Http\Controllers\ApiV1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\General\ToChangeRoleRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoriesInterface;
use App\Traits\PublicJsonResponse;

class ChangeRoleController extends Controller
{
    use PublicJsonResponse;

    private UserRepositoriesInterface $userRepositories;

    public function __construct(UserRepositoriesInterface $userRepositories)
    {
        return $this->userRepositories = $userRepositories;
    }

    public function __invoke(ToChangeRoleRequest $request)
    {

        $user = $this->userRepositories->getById($request->input('user_id'));
        $this->userRepositories->updateById($user->id, ['role' => User::AUTHOR]);

        return $this->messageResponse('Role Changed!', 200);

    }
}
