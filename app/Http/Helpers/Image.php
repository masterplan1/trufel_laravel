<?php

namespace App\Http\Helpers;

use Illuminate\Http\UploadedFile;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Image
{
  public static function saveImage(UploadedFile $image) : string
    {
        $path = '/images/' . Str::random() . '-' . time();
        $public_path = '/public' . $path;
        if(!Storage::exists($public_path)){
            Storage::makeDirectory($public_path, 0755, true);
        }
        if(!Storage::putFileAs($public_path, $image, $image->getClientOriginalName())){
            throw new Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }
        return $path . '/' . $image->getClientOriginalName();
    }

    public static function removeImage(string $image){
        $a = explode('/', $image);
        if(is_array($a) && count($a) > 4){
            $path = 'public/' . implode('/', [$a[4], $a[5], $a[6]]);
            if(Storage::exists($path)){
                Storage::deleteDirectory($path);
                return true;
            }
        }
    }
}