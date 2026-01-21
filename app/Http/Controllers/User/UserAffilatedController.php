<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAffilatedController extends Controller
{
    public function affiliate_signup(){
        return View('affiliatedUser.register');
    }

     public function affiliate_otpVerify(){
        return View('affiliatedUser.otpverify');
    }

     public function affiliate_addaddress(){
        return View('affiliatedUser.addaddress');
    }

     public function affiliateAddBankDetails(){
        return View('affiliatedUser.addBankInformation');
    }
    

}