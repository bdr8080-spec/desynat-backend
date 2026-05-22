<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\Admin;

class AdminLanguageController extends Controller
{

    public function AdminChangelanguage(Request $request,$locale){

    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        session(['lang' => $locale]);
        
    }
    
    if(Auth::guard('admin')->check() && Auth::guard('admin')->user()){
        $user_id=Auth::guard('admin')->user()->id;
        Admin::where('id',$user_id)->update(['lang'=>$locale]);
    }

    return redirect()->back();



    }




}
