<?php

namespace App\Core\Uploader\Files;

use App\Core\Uploader\Uploader;
use App\Models\Question;

class QuestionFilesUploader extends Uploader
{
    protected function disk(): string
    {
        return "general";
    }

    protected function folders(): string
    {
        return "exam";
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
        return Question::class;
    }

    protected function placeHolder(): string
    {
        return $this->domain .$this->disk(). "/public/Baner.png";
    }
}
