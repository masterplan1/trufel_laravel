<?php

namespace App\Http\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image as ImageFacade;
use Exception;

class Image
{
    private const MAX_WIDTH  = 1920;
    private const MAX_HEIGHT = 1920;
    private const QUALITY    = 82;

    public static function saveImage(UploadedFile $image): string
    {
        $dir  = 'images/' . Str::random() . '-' . time();
        $filename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.jpg';
        $storagePath = 'public/' . $dir . '/' . $filename;

        $processed = ImageFacade::read($image)
            ->scaleDown(self::MAX_WIDTH, self::MAX_HEIGHT)
            ->toJpeg(self::QUALITY);

        if (!Storage::put($storagePath, (string) $processed)) {
            throw new Exception("Unable to save file \"{$filename}\"");
        }

        return $dir . '/' . $filename;
    }

    public static function removeImage(string $image): bool
    {
        $dir = 'public/' . dirname($image);
        if (Storage::exists($dir)) {
            Storage::deleteDirectory($dir);
            return true;
        }
        return false;
    }
}
