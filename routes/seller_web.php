<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Seller\LoginController;


Route::group(['prefix' => 'seller'], function () {

    route::Match(['get','post'],'/register',[LoginController::class,'register']);
    route::Match(['get','post'],'/register-otp-verify',[LoginController::class,'register_otp_verify']);
    route::Match(['get','post'],'/store_information',[LoginController::class,'store_information']);
    route::Match(['get','post'],'/upload_document',[LoginController::class,'upload_document']);

    route::Match(['get','post'],'/upload_summary',[LoginController::class,'upload_summary']);

    route::Match(['get','post'],'/signup-review',[LoginController::class,'signup_review']);
    

    route::Match(['get','post'],'/login',[LoginController::class,'login']);
    route::Match(['get','post'],'/verify-otp',[LoginController::class,'verify_otp']);


    route::Match(['get','post'],'/reset_password',[LoginController::class,'reset_password']);


});