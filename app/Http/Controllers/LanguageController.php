<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Validator;
use App\Models\User;
use App\Helpers\ApiResponse;
use Auth;


class LanguageController extends Controller
{

    // public function seller_lang(Request $req)
    // {
    //     $seller_language= Auth::guard('seller')->user();
        
    //     $language =  $req->lang;

    //     $seller_language->update(['lang'=>$language]);

    //     App::Setlocale($language);
    //     session(['lang' => $language]);

    //     return back()->with(['messages' => "Language change Successfully"]);
    // }


public function seller_lang(Request $req)
{
    $req->validate([
        'lang' => 'required|in:en,ar,fr' // adjust languages
    ]);

    $language = $req->lang;

    $seller = Auth::guard('seller')->user();
    $seller->update(['lang' => $language]);

    session(['lang' => $language]);
    App::setLocale($language);

    dump(App::getLocale());
    
    return back()->with('message', 'Language changed successfully');
}



public function user_lang(Request $req)
{
    $req->validate([
        'lang' => 'required|in:en,ar,fr' // adjust languages
    ]);

    $language = $req->lang;

    $seller = Auth::guard('web')->user();
    $seller->update(['lang' => $language]);

    session(['lang' => $language]);
    App::setLocale($language);

    
    return back()->with('message', 'Language changed successfully');
}

public function setCountryInUser(Request $request){

    $user_detail = Auth::guard('web')->user();

    if($user_detail){
        $user_detail->selected_country=$request->country_id;
    }

    session(['country_id' => $request->country_id]);
    return response()->json(['status' => true]);
}

public function setCurrencyInUser(Request $request){

    $user_detail = Auth::guard('web')->user();

    if($user_detail){
        $user_detail->selected_currency=$request->currency;
    }



     session(['currency' => $request->currency]);
    return response()->json(['status' => true]);
}


}