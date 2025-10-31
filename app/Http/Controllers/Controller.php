<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;


abstract class Controller
{
    //

    public function image_upload($file,$dir){

        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $filepath  = $dir . $fileName;
        $resp =  Storage::disk('s3')->put($filepath, file_get_contents($image));
     
        $image_url = 'https://desynat-bucket.s3.me-south-1.amazonaws.com/' . $resp;
        return  $resp;
    }

}