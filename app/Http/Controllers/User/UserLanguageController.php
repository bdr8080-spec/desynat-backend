<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\AffilatedUser;

use Auth;

class UserLanguageController extends Controller
{

    public function UserChangelanguage(Request $request,$locale){

    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        session(['lang' => $locale]);
        
    }

    if(Auth::guard('web')->check() && Auth::guard('web')->user()){
        $user_id=Auth::guard('web')->user()->id;
        User::where('id',$user_id)->update(['lang'=>$locale]);
        AffilatedUser::where('user_id',$user_id)->update(['lang'=>$locale]);
    }

    return redirect()->back();



    }




}
