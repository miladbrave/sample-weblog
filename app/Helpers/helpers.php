<?php

use App\Core\Uploader\Entities\File as Entity;
use App\Models\File;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

if (!function_exists("checkEmail")) {
    function checkEmail(string $email): ?string
    {
        if (checkValidateEmail($email))
            return "email";

        return null;
    }
}

if (!function_exists("checkValidateEmail")) {
    function checkValidateEmail($email)
    {
        $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z0-9]+(\.)+[a-zA-Z]{2,3})$/";
        return preg_match($regex, $email);
    }
}

if (!function_exists("uploadImage")) {
    function uploadImage($file, $user_id, $name = "", $fileable = null, $path = '/files', $disk = 'public')
    {
        $uploads_dir = $path;
        if ($file) {
            $randName = Uuid::uuid4() . '.' . $file->getClientOriginalExtension();
            $f = null;
            if ($fileable) {
                $f = $fileable->File()->create([
                    'name' => $name,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'disk' => $disk,
                    'path' => $path . "/$randName",
                    'user_id' => $user_id,
                ]);
            } else {
                $f = File::create([
                    'name' => $name,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'disk' => $disk,
                    'path' => $path . "/$randName",
                    'user_id' => $user_id,
                ]);
            }
            Storage::disk($disk)->putFileAs($uploads_dir, $file, $randName);
            return $f->id;
        }
        return "";
    }
}

if (!function_exists("removeImage")) {
    function removeImage($id,$disk = 'public')
    {
        $file = File::findOrFail($id);

        if ($file) {
            Storage::disk($disk)->delete($file->path);
            $file->delete();
            return true;
        }
        return false;
    }
}
