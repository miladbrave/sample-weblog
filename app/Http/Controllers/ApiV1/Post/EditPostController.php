<?php

namespace App\Http\Controllers\ApiV1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\post\EditPostRequest;
use App\Repositories\Interfaces\PostRepositoriesInterface;
use App\Repositories\Interfaces\TagRepositoriesInterface;
use App\Traits\PublicJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class EditPostController extends Controller
{
    use PublicJsonResponse;

    private PostRepositoriesInterface $postRepositories;
    private TagRepositoriesInterface $tagRepositories;

    public function __construct(PostRepositoriesInterface $postRepositories, TagRepositoriesInterface $tagRepositories)
    {
        $this->postRepositories = $postRepositories;
        $this->tagRepositories = $tagRepositories;
    }


    public function __invoke(EditPostRequest $request)
    {
        $post = $this->postRepositories->getPostWithSlug($request['slug']);

        if (!Gate::allows('update-post', [$post,auth()->user()])) {
            return $this->messageResponse("Access Denied");
        }
        $this->postRepositories->updateById($post->id, [
            'title' => $request->input("title"),
            'description' => $request->input("description"),
            'category_id' => $request->input('category'),
            'slug' => Str::slug($request->input("title")),
            'user_id' => auth()->id(),
            'image' => 1,
        ]);

        $tags = $request->input('tags');
        $tags_id = $this->tagRepositories->createOrUpdateTags($tags);
        $this->postRepositories->postSyncTags($post, $tags_id);

        return $this->messageResponse('post Updated', 200);
    }
}
