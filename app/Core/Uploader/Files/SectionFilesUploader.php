<?php

namespace App\Core\Uploader\Files;

use App\Core\Uploader\Uploader;
use App\Models\Section;

class SectionFilesUploader extends Uploader
{

    protected function disk(): string
    {
        return "general";
    }

    protected function folders(): string
    {
        return "teacher/section";
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
        return Section::class;
    }

    protected function placeHolder(): string
    {
        return $this->domain .$this->disk(). "/public/Baner.png";
    }
}
