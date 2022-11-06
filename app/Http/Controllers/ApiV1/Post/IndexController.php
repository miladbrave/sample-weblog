<?php

namespace App\Http\Controllers\ApiV1\Post;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostRepositoriesInterface;
use App\Traits\PublicJsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    use PublicJsonResponse;

    private $postRepositories;

    public function __construct(PostRepositoriesInterface $postRepositories)
    {
        $this->postRepositories = $postRepositories;
    }

    public function __invoke()
    {
        $date = $this->postRepositories->showAllPosts();

        return $this->dataResponse(null,$date,200);
    }
}
