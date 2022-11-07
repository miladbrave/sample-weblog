<?php

namespace App\Repositories\Interfaces;

use App\Core\Repositories\BaseRepositoryInterface;

interface FileRepositoriesInterface extends BaseRepositoryInterface
{
    public function uploadPostImages($file, $user_id, $name = "", $fileable = null, $path = '/files', $disk = 'web');
}
