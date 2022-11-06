<?php

namespace App\Http\Controllers\ApiV1\Authenticate;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoriesInterface;
use App\Traits\PublicJsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use PublicJsonResponse;

    private UserRepositoriesInterface $userRepositories;

    public function __constructor(UserRepositoriesInterface $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    public function __invoke(LoginRequest $request)
    {
        $data = $request->validated();
        $email = $data['username'];
        $user = $this->userRepositories->findUserByEmail($email);

        if (!$user)
            throw ValidationException::withMessages(['username' => 'user not found']);

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(["all" => ["These credentials do not match our records"]]);
        }

        $token = $user->createToken('API');
        $role       = User::UserRole[$user->role];

        $data = [
            'token'         => $token->plainTextToken,
            'user'          => new UserResource($user,$role),
            'role'          => $role,
        ];

        return $this->dataResponse(null, $data, 200, false);
    }
}
