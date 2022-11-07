<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoriesInterface;

class PostRepositories extends BaseRepository implements PostRepositoriesInterface
{

    public function model(): string
    {
        return Post::class;
    }

    public function showAllPosts()
    {
        return $this->query()->paginate(20);
    }

    public function createPost($data)
    {
        return $this->query()->create($data);
    }

    public function postSyncTags(Post $post,$tags)
    {
        return  $post->Tags()->sync($tags);
    }

    public function getPostWithSlug($value)
    {
        $this->query()->where('slug',$value)->first();
    }
}
