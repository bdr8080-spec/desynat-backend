<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAffiliatedProfileController extends Controller
{
    public function affiliateProfile(Request $request){

        return view('affiliatedUser.profiles.profile');
    
    
    }




}