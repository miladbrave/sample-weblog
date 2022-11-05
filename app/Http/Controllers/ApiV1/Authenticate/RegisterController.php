<?php

namespace App\Http\Controllers\ApiV1\Authenticate;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\auth\RegisterRequest;
use App\Repositories\Interfaces\UserRepositoriesInterface;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    private UserRepositoriesInterface $userRepositories;

    public function __constructor(UserRepositoriesInterface $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    public function __invoke(RegisterRequest $request)
    {

        $register_data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        $this->userRepositories->create($register_data);
        $this->userRepositories->makePassword($this->input('password'));

        $token = $this->userRepositories->getCurrentUser()->createToken('API');

        $data = [
            'token'         => $token->plainTextToken,
        ];

        return $this->dataResponse(null, $data, 200, true);
    }
}
