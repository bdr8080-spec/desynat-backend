<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLanguageController extends Controller
{

    public function UserChangelanguage(Request $request,$locale){

    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        session(['lang' => $locale]);
        
    }

    return redirect()->back();



    }




}
