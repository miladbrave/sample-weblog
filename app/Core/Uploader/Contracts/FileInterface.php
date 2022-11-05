<?php


namespace App\Core\Uploader\Contracts;


use App\Core\Uploader\Entities\File as Entity;
use App\Models\File;
use Illuminate\Http\UploadedFile;

interface FileInterface
{
    public function find($id) : ?Entity;

    public function upload(UploadedFile $file,string $sub_folder = ""): ?Entity;

    public function preSign(string $name,string $type,int $size) : ?Entity;

    public function delete(File|string|int $file) : bool;

    public function fetch(int|File|Entity $file,?int $type_id = null) : bool;

    public function getUrl($id) : string;

    public function generateUrl(File|string|Entity $file) : string;
}
