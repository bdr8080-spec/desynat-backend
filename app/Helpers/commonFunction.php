<?php


use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

use App\Models\{seller};
use Illuminate\Support\Facades\Auth;

use App\Models\{SellerMenus_table,sellermenuAction};
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;



 function image_upload($file,$dir){

    $fileName = time() . '.' . $file->getClientOriginalExtension();

    $filepath  = $dir . $fileName;

    $resp =  Storage::disk('s3')->put($filepath, file_get_contents($file));
 
    // $image_url = 'https://desynat-bucket.s3.me-south-1.amazonaws.com/' . $filepath;
    $image_url = 'https://d79swovq1y56s.cloudfront.net/' . $filepath;

    return  $image_url;
}

 function doc_upload($file, $dir)
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $dir . '/' . $fileName;
        //dd($filePath);
        $resp = Storage::disk('s3')->put($filePath, file_get_contents($file));
        // $image_url = 'https://desynat-bucket.s3.me-south-1.amazonaws.com/' . $filePath;
        $image_url = 'https://d79swovq1y56s.cloudfront.net/' . $filePath;
        return $image_url;
    }

function Generate_SellerQrCode($seller_id,$store_id){

    // $qrSellerCode = url()->full();

   $qrSellerCode= url('/')."/user/store-details/".$store_id;
   
    $fileName = 'qr_' . time() . '.svg';
    // Generate SVG content
    $svg = QrCode::format('svg')
        ->size(300)
        ->generate($qrSellerCode);
    // Upload directly to S3 (NO local file needed)
     Storage::disk('s3')->put($fileName, $svg, 'QR_Code');
    // Get correct S3 URL
    $image_url = Storage::disk('s3')->url($fileName);

    $image_url = 'https://d79swovq1y56s.cloudfront.net/' . $fileName;


    seller::where('id',$seller_id)->update(['profile_qr'=>$image_url,'qrSellerUrl'=>$qrSellerCode]);
    
}

if (!function_exists('getSellerMenus')) {
    function getSellerMenus()
    {

        if(Auth::guard('seller')->check() && Auth::guard('seller')->user()->type=='1'){

           $Actionmenu= sellermenuAction::with('singleActionmenu')->where('seller_id',Auth::guard('seller')->user()->id)->pluck('menu_id');

           $data=  SellerMenus_table::whereNull('parent_id')
                ->where('status', 1)
                ->whereIn('id',$Actionmenu )
                ->with('children')
                ->orderBy('order_by')
                ->get();

                return $data;

                
        }else{

        return Cache::remember('seller_menus', 10, function () {
            return SellerMenus_table::whereNull('parent_id')
                ->where('status', 1)
                ->with('children')
                ->orderBy('order_by')
                ->get();
        });

    }

    }
}

if (!function_exists('menuActive')) {
    function menuActive($patterns, $route = null)
    {
        $patterns = json_decode($patterns, true) ?? [];

        foreach ($patterns as $pattern) {
            if (request()->is($pattern)) {
                return 'sidebar-active';
            }
        }

        if ($route && request()->routeIs($route)) {
            return 'sidebar-active';
        }

        return '';
    }
}



   function SellermenuPermission()
    {
        $user = Auth::guard('seller')->user();

        if (!$user) {
            abort(403);
        }

    $seller_id=$user->id;

    $seller_details=seller::with('seller_category','Role_Action.sellermenu')->where('id',$seller_id)->first();

    $can_view=0;
    $can_action=0;


 if($seller_details->type=='1'){
        
    $path=Request::path();

    $Web_url = SellerMenus_table::whereJsonContains('active_patterns', $path)
    ->first();

  $menu_action=sellermenuAction::where('menu_id',$Web_url->id)
->where('seller_id', $seller_id)->first();


    if($menu_action){
            
    if($menu_action->can_view=='0'){
            // return redirect()->back();
            abort(403, 'No permission');

        }
    $can_view=$menu_action->can_view;
    $can_action=$menu_action->can_action;

    }else{

             abort(403, 'No permission');
        }

}else{

$can_view=1;
$can_action=1;

}

return [
    'can_view'=>$can_view,
    'can_action'=>$can_action
];

    }



if (!function_exists('sellerAndStaffId')) {

    function sellerAndStaffId()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) return null;

        // 🔥 your logic
        return ($seller->type == 1 && $seller->parent_id)
            ? $seller->parent_id
            : $seller->id;
    }
}