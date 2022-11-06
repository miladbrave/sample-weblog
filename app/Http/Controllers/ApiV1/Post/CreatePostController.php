<?php

namespace App\Http\Controllers\ApiV1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\post\CreateRequest;
use App\Repositories\Interfaces\PostRepositoriesInterface;
use App\Traits\PublicJsonResponse;
use Illuminate\Http\Request;

class createPostController extends Controller
{

    use PublicJsonResponse;

    private PostRepositoriesInterface $postRepositories;

    public function __constructor(PostRepositoriesInterface $postRepositories)
    {
        $this->postRepositories = $postRepositories;
    }

    public function __invoke(CreateRequest $request)
    {

        $post = $this->postRepositories->createPost([
            'title'         => $request->input("title"),
            'description'   => $request->input("description"),
            'category_id'   => $request->input('category_id'),
            'user_id'       => auth()->id(),
        ]);

        $tags = $request->input('tags');
        $this->postRepositories->postSyncTags($post,$tags);

    }
}
