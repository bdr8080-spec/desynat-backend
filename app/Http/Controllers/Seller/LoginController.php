<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){


        return view('dealer.login');

    }

    public function verify_otp(Request $request){

        return view('dealer.otp_verify');
    
    }

    public function register(Request $request){
        return view('dealer.sign-up');
    }


    public function register_otp_verify(Request $request){
        return view('dealer.signup_otp');
    }


    public function store_information(Request $request){
        return view('dealer.store_page');
    }

    public function upload_document(Request $request){
        return view('dealer.bank-details');
    }


    public function upload_summary(Request $request){
        return view('dealer.summary_page');
    }

    public function signup_review(Request $request){
        return view('dealer.signup-review');
    }


    public function reset_password(Request $request){
        return view('dealer.reset_password');
    }

    
    public function forgot_password(Request $request){
        return view('dealer.forgot');
    }

}
