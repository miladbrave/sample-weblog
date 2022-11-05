<?php


namespace App\Core\Uploader;


use App\Core\Uploader\Contracts\FileInterface;
use App\Core\Uploader\Entities\File as Entity;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

abstract class Uploader implements FileInterface
{
    protected Storage $storage;
    protected string $domain;
    private bool $temporaryUrl = false ;
    private bool $useName = false ;

    private FileRepositoryInterface $repository;

    public function __construct()
    {
        $this->storage      = app()->make(Storage::class);
        $this->repository   = app()->make(FileRepositoryInterface::class);
        $this->domain       = config("global.storage_url");
    }

   public function setNeedTemporaryUrl(bool $value)
   {
       $this->temporaryUrl = $value;
   }

    public function setUseName(bool $value)
    {
        $this->useName = $value;
    }

    public function find($id) : ?Entity
    {
        $file = $this->repository->getById($id);
        if ($file)
            return new Entity($file->id,$file->path,$this->generateUrl($file),$file->name);
        return null;
    }

    public function getUrl($id) : string
    {
        $file = $this->repository->getById($id);
        if ($file)
            return  $this->generateUrl($file);

        return $this->placeHolder();
    }

    public function upload(UploadedFile $file,string $sub_folder = ""): ?Entity
    {
        $folders = $this->folders();
        if ($sub_folder) {
            $folders .= "/" . $sub_folder;
        }
        if ($this->useName)
        $path = $this->storage->upload($file,$this->disk(),$folders , $file->getClientOriginalName());
        else
            $path = $this->storage->upload($file,$this->disk(),$folders);
        if ($path == "")
            return null;



        $entity = $this->repository->create([
            'name'          => $file->getClientOriginalName(),
            'original_name' => $file->getClientOriginalName(),
            'size'          => $file->getSize(),
            'type'          => $file->getMimeType(),
            'disk'          => $this->disk(),
            'path'          => $path,
            "fileable_type" => $this->model(),
        ]);

        return new Entity($entity->id,$entity->path,$this->generateUrl($entity),$entity->name);
    }

    public function preSign(string $name, string $type, int $size,string $sub_folder = ""): ?Entity
    {
        $folders = $this->folders();
        if ($sub_folder) {
            $folders .= "/" . $sub_folder;
        }

        [$url , $file_name] = $this->storage->preSigne($type,$folders,$this->disk(),$name);
        if ($url == "")
            return null;

        $entity = $this->repository->create([
            'path' => $folders."/".$file_name ,
            'name' => $name,
            'type' => $type,
            'size' => $size,
            'disk' => $this->disk(),
        ]);

        return new Entity($entity->id,$entity->path,$url,$entity->name);
    }

    public function delete(int|string|File $file) : bool    
    {
        if (is_int($file)) {
            $file = $this->repository->getById($file);
            if (!$file)
                return false;
            $this->repository->deleteById($file->id);
        }elseif (is_string($file)){
            $file = $this->folders() ."/" . $file;
        }

        return $this->storage->delete($file,$this->disk());
    }

    public function fetch(int|File|Entity $file,?int $type_id = null): bool
    {
        if ($file instanceof File || $file instanceof Entity)
            $id = $file->id;
        else
            $id = $file;

        $res = $this->repository->updateById($id,[
            "fileable_type" => $this->model(),
            "fileable_id"   => $type_id
        ]);

        return (bool)$res;
    }

    public function generateUrl(File|string|Entity $file) : string
    {
        if ($file instanceof File){
            $path = $file->path;
            $key  = $file->id;
            $disk = $file->disk;
        }elseif($file instanceof Entity){
            $path = $file->path;
            $key  = $file->path;
            $disk = $this->disk();
        }else{
            $path = $file;
            $key  = $file;
            $disk = $this->disk();
        }

        if ($this->temporaryUrl) {
            if ($this->needCache()){
                $url = $this->getCache( $this->cacheKey($key) );
                if ($url)
                    return $url;
            }

            if ($expire = $this->expireTime())
                $time = now()->addMinutes($expire);
            else
                $time = now()->addMinutes(30);

            $url = $this->storage->generateTemporaryUrl($disk,$path,$time);

            if ($this->needCache()){
                $this->storeCache($this->cacheKey($key),$url,$expire);
            }

        } else {
            /*$time = now()->addDays(20);
            $url = $this->storage->generateStaticUrl($disk,$path,$time);
            if ($this->needCache()){
                $this->storeCache($this->cacheKey($key),$url,$time);
            }*/
            $url = $this->domain . $this->disk() . "/" . $path;
        }

        return $url;
    }



    protected function storeCache($key,$url,$expire = null)
    {
        Cache::put($key,$url,$expire);
    }

    protected function getCache($key) : string
    {
        return Cache::get($key,"");
    }

    protected function cacheKey($key): string
    {
        return "files:urls:" . $key;
    }








    abstract protected function disk():string;

    abstract protected function folders():string;

    abstract protected function needTemporaryUrl():bool;

    abstract protected function needCache():bool;

    abstract protected function expireTime():int;

    abstract protected function model():string;

    abstract protected function placeHolder():string;

}
