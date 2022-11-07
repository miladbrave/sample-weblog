<?php

namespace App\Http\Controllers\ApiV1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\post\CreateRequest;
use App\Repositories\Interfaces\PostRepositoriesInterface;
use App\Repositories\Interfaces\TagRepositoriesInterface;
use App\Repositories\TagRepositories;
use App\Traits\PublicJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreatePostController extends Controller
{

    use PublicJsonResponse;

    private PostRepositoriesInterface $postRepositories;
    private TagRepositoriesInterface $tagRepositories;

    public function __construct(PostRepositoriesInterface $postRepositories, TagRepositoriesInterface $tagRepositories)
    {
        $this->postRepositories = $postRepositories;
        $this->tagRepositories = $tagRepositories;
    }

    public function __invoke(CreateRequest $request)
    {
        try {
            $post = $this->postRepositories->createPost([
                'title' => $request->input("title"),
                'description' => $request->input("description"),
                'category_id' => $request->input('category'),
                'slug' =>Str::slug($request->input("title")),
                'user_id' => auth()->id(),
                'image' => 1,
            ]);

            $tags = $request->input('tags');
            $tags_id = $this->tagRepositories->createOrUpdateTags($tags);
            $this->postRepositories->postSyncTags($post, $tags_id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            logger()->error("Error during insert course : ", ["exception" => $exception]);
            return $this->messageResponse("There was a problem saving the post. Please try again.");
        }


        return $this->messageResponse('post created', 200);
    }
}
