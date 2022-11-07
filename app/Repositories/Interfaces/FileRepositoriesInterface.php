<?php

namespace App\Repositories\Interfaces;

interface FileRepositoriesInterface
{
    public function uploadPostImages($file, $user_id, $name = "", $fileable = null, $path = '/files', $disk = 'web');
}
