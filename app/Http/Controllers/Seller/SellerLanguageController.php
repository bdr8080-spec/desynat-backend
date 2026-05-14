<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\seller;

class SellerLanguageController extends Controller
{

    public function SellerChangelanguage(Request $request,$locale){

    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        session(['lang' => $locale]);
        
    }

     $seller_details=sellerAndStaffId();

    if($seller_details){
        seller::where('id',$seller_details)->update(['lang' => $locale]);     
    }
    
    return redirect()->back();

    }




}