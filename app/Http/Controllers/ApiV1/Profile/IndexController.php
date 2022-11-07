<?php

namespace App\Http\Controllers\ApiV1\Profile;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoriesInterface;
use App\Traits\PublicJsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    
    use PublicJsonResponse;
    
    private UserRepositoriesInterface $userRepositories;

    public function __construct(UserRepositoriesInterface $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    public function __invoke()
    {
        
    }
}
