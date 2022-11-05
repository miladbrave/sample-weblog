<?php


namespace App\Core\Uploader\Entities;


class File
{
    public ?int     $id;
    public string   $url;
    public string   $name;
    public string   $path;

    public function __construct(?int $id,string $path ,string $url,string $name)
    {
        $this->id   = $id;
        $this->path = $path;
        $this->url  = $url;
        $this->name = $name;
    }
}
