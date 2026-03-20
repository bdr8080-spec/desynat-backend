<?php


use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

use App\Models\{seller};



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

function Generate_SellerQrCode($seller_id){

    // $qrSellerCode = url()->full();

   $qrSellerCode= url('/')."/user/store-details/".$seller_id;
   
    $fileName = 'qr_' . time() . '.svg';
    // Generate SVG content
    $svg = QrCode::format('svg')
        ->size(300)
        ->generate($qrSellerCode);
    // Upload directly to S3 (NO local file needed)
    Storage::disk('s3')->put($fileName, $svg, 'QR_Code');
    // Get correct S3 URL
    $image_url = Storage::disk('s3')->url($fileName);

    seller::where('id',$seller_id)->update(['profile_qr'=>$image_url,'qrSellerUrl'=>$qrSellerCode]);

}