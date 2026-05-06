<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerLanguageController extends Controller
{

    public function SellerChangelanguage(Request $request,$locale){

    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        session(['lang' => $locale]);
        
    }

    return redirect()->back();



    }




}
