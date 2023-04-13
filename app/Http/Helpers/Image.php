<?php

namespace App\Http\Helpers;

use App\Models\Optimize;
use CURLFile;
use Illuminate\Http\UploadedFile;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Image
{
    public static function saveImage(UploadedFile $image): string
    {
        $path = '/images/' . Str::random() . '-' . time();
        $public_path = '/public' . $path;
        if (!Storage::exists($public_path)) {
            Storage::makeDirectory($public_path, 0755, true);
        }
        if (!Storage::putFileAs($public_path, $image, $image->getClientOriginalName())) {
            throw new Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }
        return $path . '/' . $image->getClientOriginalName();
    }

    public static function removeImage(string $image)
    {
        $a = explode('/', $image);
        if (is_array($a) && count($a) > 4) {
            $path = 'public/' . implode('/', [$a[4], $a[5], $a[6]]);
            if (Storage::exists($path)) {
                Storage::deleteDirectory($path);
                return true;
            }
        }
    }

    public static function optimize()
    {
        $imageStoragePath = storage_path('app/public/images');
        $dirs = [$imageStoragePath];
        $exts = array('png', 'jpg', 'jpeg');

        $items = Optimize::where(['done' => 0, 'error' => null])->orderBy('id', 'desc')->get()->toArray();
        
        if (empty($items)) {
            
            foreach ($dirs as $dir) {
                foreach (Optimize::globRecursive($dir . '/*.*') as $file) {
                    
                    $ext = strtolower((substr(strrchr($file, '.'), 1)));
                    // echo $ext;exit;
                    if (in_array($ext, $exts)) {
                        $file = str_replace($imageStoragePath, '', $file);
                        $newFiles = Optimize::where('img', $file)->get();
                        if (count($newFiles) === 0) {
                            // print_r(count($newFiles));exit;
                            Optimize::create(['img' => $file]);
                        }
                    }
                }
            }
        } elseif (isset($items[0]) && !is_file($imageStoragePath . $items[0]['img'])) {
            echo 'delete' . PHP_EOL;
            // echo $imageStoragePath . $items[0]['img'];exit;
            Optimize::find($items[0]['id'])->delete();
        } else {
            $file = $imageStoragePath . $items[0]['img'];
            $mime = mime_content_type($file);
            $info = pathinfo($file);
            $name = $info['basename'];
            $output = new CURLFile($file, $mime, $name);
            $data = array(
                "files" => $output,
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('IMAGE_OPTIMIZE_API'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                $result = curl_error($ch);
            }
            curl_close($ch);

            $res = json_decode($result, JSON_OBJECT_AS_ARRAY);

            if (!empty($res['error'])) {
                Optimize::find($items[0]['id'])->update(['error' => $res['error']]);
            } elseif (!empty($res['output'])) {
                $file = $imageStoragePath . $items[0]['img'];

                // if(rename($file, $file . '.bak')) {
                if (copy($res['dest'], $file)) {
                    $diff = $res['src_size'] = $res['dest_size'];
                    Optimize::find($items[0]['id'])->update(['done' => 1, 'diff' => $diff]);
                    exit();
                }
                Optimize::find($items[0]['id'])->update(['error' => 'error file replacement']);
            }
        }
    }
}
