<?php

namespace App\Http\Controllers\ApiV1\Post;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostRepositoriesInterface;
use App\Traits\PublicJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeletePostController extends Controller
{
    use PublicJsonResponse;

    private PostRepositoriesInterface $postRepositories;
    public function __construct(PostRepositoriesInterface $postRepositories)
    {
        $this->postRepositories = $postRepositories;
    }

    public function __invoke($postId)
    {
        $post = $this->postRepositories->getById($postId);

        if (!$post)
            throw new NotFoundHttpException('Not Found');

        if (!Gate::allows('delete-post', [$post, auth()->user()])) {
            abort(403, "Access Denied");
        }

        $this->postRepositories->deleteById($postId);

        return $this->messageResponse('post deleted', 200);
    }

}
