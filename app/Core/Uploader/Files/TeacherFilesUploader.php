<?php


namespace App\Core\Uploader\Files;


use App\Core\Uploader\Uploader;
use App\Models\Teacher;

class TeacherFilesUploader extends Uploader
{

    protected function disk(): string
    {
        return "general";
    }

    protected function folders(): string
    {
        return "teacher";
    }

    protected function needTemporaryUrl(): bool
    {
        return false;
    }

    protected function needCache(): bool
    {
        return false;
    }

    protected function expireTime(): int
    {
        return 0;
    }

    protected function model(): string
    {
        return Teacher::class;
    }

    protected function placeHolder(): string
    {
        return $this->domain .$this->disk(). "/public/Baner.png";
    }

}
