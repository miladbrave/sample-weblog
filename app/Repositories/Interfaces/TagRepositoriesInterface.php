<?php

namespace App\Repositories\Interfaces;


use App\Core\Repositories\BaseRepositoryInterface;

interface TagRepositoriesInterface extends BaseRepositoryInterface
{

    public function createOrUpdateTags($tags);

}
