<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;

interface PostRepositoriesInterface
{
    public function showAllPosts();

    public function createPost($data);

    public function postSyncTags(Post $post,$tags);

    public function getPostWithSlug($slug);

    public function uploadImage($post,$request);

}
