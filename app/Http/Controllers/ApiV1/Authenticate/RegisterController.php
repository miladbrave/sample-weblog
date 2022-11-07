<?php

namespace App\Http\Controllers\ApiV1\Authenticate;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\auth\RegisterRequest;
use App\Repositories\Interfaces\UserRepositoriesInterface;
use App\Traits\PublicJsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use PublicJsonResponse;

    private UserRepositoriesInterface $userRepositories;

    public function __construct(UserRepositoriesInterface $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    public function __invoke(RegisterRequest $request)
    {

        try {
            $register_data = [
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'password'  => Hash::make($request->input('password'))
            ];

            $this->userRepositories->createUser($register_data);

            $user = $this->userRepositories->findUserByEmail($request->input('email'));

            if (!$user)
                throw ValidationException::withMessages(["email" => ["There is not user"]]);

            $token = @$user->createToken('API');
            $data = [
                'token'         => $token->plainTextToken,
            ];

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            logger()->error("Error during insert course : " , ["exception" => $exception]);
            return $this->messageResponse("There was a problem saving the course. Please try again.");
        }

        return $this->dataResponse(null, $data, 200, true);
    }
}
