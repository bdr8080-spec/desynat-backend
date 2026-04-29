<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Validator;
use App\Models\{User,country,all_countrie};
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

    $selectCountry=all_countrie::where('id',$request->country_id)->first();

      if($selectCountry){
        
       session([
        'countryName' => $selectCountry->name, // table id
        'countrydialCode' => $selectCountry->dial_code,
        'country_id' => $request->country_id
    ]);

   }else{
        session(['country_id' => $request->country_id]);
   }

    if($user_detail){

    User::where('id',$user_detail->id)->update(['selected_country'=> IntVal($request->country_id)]);

    }


    

    return response()->json(['status' => true]);
}

public function setCurrencyInUser(Request $request){

    $user_detail = Auth::guard('web')->user();

    $selectCountry=all_countrie::where('currency_code',$request->currency)->first();

    if($user_detail){

        User::where('id',$user_detail->id)->update(['selected_currency'=> IntVal($selectCountry->id)]);
        // $user_detail->selected_currency=IntVal($request->currency);
    }
    
   if($selectCountry){
       session([
        'currency' => $request->currency, // table id
        'iso_code' => $selectCountry->iso_code,
        'rate' => $selectCountry->exchange_rate_to_kwd ?? 1
    ]);

   }else{
        session(['currency' => $request->currency]);
   }

    return response()->json(['status' => true]);
}


}