<?php
namespace App\Core\Uploader;


use App\Models\File;
use Aws\S3\S3Client;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\UploadedFile;

class Storage
{
    static private ?S3Client $client = null;

    /**
     * @param UploadedFile $file
     * @param string $disk
     * @param string $path
     * @param string|null $name
     * @return string
     */
    public function upload(UploadedFile $file, string $disk = 'public' , string $path = "", ?string $name = null) : string
    {
        $file_name = $name;
        if (!$name) {
            $file_name = Uuid::uuid4() . '.' . $file->getClientOriginalExtension();
        }

        $path   = $this->slashChecker($path);

        $result = \Illuminate\Support\Facades\Storage::disk($disk)->putFileAs($path, $file, $file_name);

        if (!$result)
            return "";

        return $result;
    }

    public function preSigne(
        string $mime,
        string $path = "",
        string $disk = "public",
        ?string $name = null,
        int $expire = 120
    ): array
    {
        $time = time();
        if ($name == "") {
            $file_name = now()->timestamp ."-" . Uuid::uuid4() . '.' . $mime; // TODO mime type to ext
        }else{
            $file_parts = pathinfo($name);
            if ( !key_exists("extension",$file_parts) || $file_parts["extension"] == "") {
                $file_name = $name . "-$time." . $mime;
            } else {
                $name = str_replace('.' , "-$time.",$name);
                $file_name = $name;
            }
        }

        $client = self::getS3ClientInstance();

        $expiry         = "+$expire minutes";
        $final_path     = $this->slashChecker($path) . "/" . $file_name;
        $cmd            = $client->getCommand('PutObject', [
            'Bucket' => config('filesystems.disks.' . $disk . '.bucket'),
            'Key' => $final_path,
            'ContentType'=> "binary/octet-stream",
        ]);

        $requestUrl = $client->createPresignedRequest($cmd, $expiry)->withMethod('PUT');
        return [(string)$requestUrl->getUri() , $file_name];
    }

    public function delete(File|string $file,$disk = "public"): bool
    {
        if ($file instanceof File) {
            $result = \Illuminate\Support\Facades\Storage::disk($file->disk)->delete($file->path);
        } else {
            $result = \Illuminate\Support\Facades\Storage::disk($disk)->delete($file);
        }
        return $result;
    }

    public function generateTemporaryUrl(string $disk,string $path,\DateTimeInterface $time):string
    {
        return \Illuminate\Support\Facades\Storage::disk($disk)->temporaryUrl($path,$time);
    }

    public function generateStaticUrl(string $disk,string $path,\DateTimeInterface $time):string
    {
        return \Illuminate\Support\Facades\Storage::disk($disk)->url($path,$time);
    }

    private function slashChecker(string $path) : string
    {
        if (strlen($path) == 0 || $path == '/') {
            return '/';
        }

        if (substr($path , 0,1) == '/')
        {
            $path = substr($path , 1);
        }


        if (substr($path,-1) == '/')
            $path = substr($path,0,-1);

        return $path;
    }

    static private function getS3ClientInstance(): S3Client
    {
        if (self::$client)
            return self::$client;
        return self::$client = new S3Client([
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => true,
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest'
        ]);
    }
}
