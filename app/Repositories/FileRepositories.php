<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoriesInterface;

class FileRepositories extends BaseRepository implements FileRepositoriesInterface
{
    public function model()
    {
        return File::class;
    }

    public function uploadPostImages($file, $user_id, $name = "", $fileable = null, $path = '/files', $disk = 'web')
    {

    }
}
