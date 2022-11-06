<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoriesInterface;

class TagRepositories extends BaseRepository implements TagRepositoriesInterface
{

    public function model(): string
    {
        return Tag::class;
    }

    public function createOrUpdateTags($tags)
    {
        if ($tags)
            return $this->checkTags($tags);

        return null;
    }

    private function checkTags($tags)
    {
        $getTags = [];
        foreach ($tags as $tag) {
             $getTag = $this->query()->where('title', $tag)->first();
             if (!$getTag){
                $createdTag = $this->query()->create(['title' => $tag]);
                array_push($getTags,$createdTag->id);
             }else{
                 array_push($getTags,$getTag['id']);
             }
        }
        return $getTags;
    }

}
