<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLanguageController extends Controller
{

    public function AdminChangelanguage(Request $request,$locale){

    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        session(['lang' => $locale]);
        
    }

    return redirect()->back();



    }




}
