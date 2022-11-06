<?php

namespace App\Http\Controllers\ApiV1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\post\CreateRequest;
use App\Repositories\Interfaces\PostRepositoriesInterface;
use App\Traits\PublicJsonResponse;
use Illuminate\Http\Request;

class CreatePostController extends Controller
{

    use PublicJsonResponse;

    private PostRepositoriesInterface $postRepositories;

    public function __constructor(PostRepositoriesInterface $postRepositories)
    {
        $this->postRepositories = $postRepositories;
    }

    public function __invoke(CreateRequest $request)
    {

        try {
            $post = $this->postRepositories->createPost([
                'title' => $request->input("title"),
                'description' => $request->input("description"),
                'category_id' => $request->input('category_id'),
                'user_id' => auth()->id(),
            ]);

            $tags = $request->input('tags');
            $this->postRepositories->postSyncTags($post, $tags);
        } catch (\Exception $exception) {
            logger()->error("Error during insert course : " , ["exception" => $exception]);
            return $this->messageResponse("There was a problem saving the course. Please try again.");
        }


        return $this->messageResponse('post created', 200);
    }
}
