<?php


 function image_upload($file,$dir){

    $fileName = time() . '.' . $file->getClientOriginalExtension();

    $filepath  = $dir . $fileName;

    $resp =  Storage::disk('s3')->put($filepath, file_get_contents($file));
 
    $image_url = 'https://desynat-bucket.s3.me-south-1.amazonaws.com/' . $filepath;

    return  $image_url;
}

 function doc_upload($file, $dir)
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $dir . '/' . $fileName;
        $resp = Storage::disk('s3')->put($filePath, file_get_contents($file));
        $image_url = 'https://desynat-bucket.s3.me-south-1.amazonaws.com/' . $filePath;
        return $image_url;
    }