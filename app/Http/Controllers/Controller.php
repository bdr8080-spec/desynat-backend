<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;


abstract class Controller
{
    //


public function image_upload($file, $dir)
{
    try {
        $dir = rtrim($dir, '/') . '/';

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $filePath = $dir . $fileName;

        $uploaded = Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');

                dd($uploaded);


        if ($uploaded) {
           return  Storage::disk('s3')->url($filePath);
        } else {
            return null;
        }

    } catch (\Exception $e) {
        \Log::error('S3 Upload Error: ' . $e->getMessage());
        return null;
    }
}


}