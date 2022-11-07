<?php

namespace App\Repositories\Interfaces;

use App\Core\Repositories\BaseRepositoryInterface;
use App\Models\Post;

interface PostRepositoriesInterface extends BaseRepositoryInterface
{
    public function showAllPosts();

    public function createPost($data);

    public function postSyncTags(Post $post,$tags);

    public function getPostWithSlug($slug);

    public function uploadImage($post,$request);

    public function removePostImage($id);

}
