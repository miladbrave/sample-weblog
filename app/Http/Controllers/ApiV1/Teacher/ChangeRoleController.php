<?php

namespace App\Http\Controllers\ApiV1\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\teacher\ToChangeRoleRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoriesInterface;
use App\Traits\PublicJsonResponse;
use Illuminate\Support\Facades\DB;

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
        try {
            $user = $this->userRepositories->getById($request->input('user_id'));
            $this->userRepositories->updateById($user->id,['role' => User::AUTHOR]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            logger()->error("Error during insert course : ", ["exception" => $exception]);
            return $this->messageResponse("There was a problem changing role. Please try again.");
        }

        return $this->messageResponse('Role Changed!', 200);

    }
}
