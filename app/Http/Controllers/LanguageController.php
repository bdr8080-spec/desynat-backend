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

    public function seller_lang(Request $req)
    {
        $seller_language= Auth::guard('seller')->user();
        
        $language =  $req->lang;

        $seller_language->update(['lang'=>$language]);

        App::Setlocale($language);
        session(['lang' => $language]);

        return back()->with(['messages' => "Language change Successfully"]);
    }


}