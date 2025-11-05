<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Seller\LoginController;


Route::group(['prefix' => 'seller'], function () {


    Route::middleware(['is_seller'])->group(function(){
        
    route::Match(['get','post'],'/login',[LoginController::class,'login'])->name('seller.login');
    route::Match(['get','post'],'/register',[LoginController::class,'register'])->name('seller.register');

    route::Match(['get','post'],'/otp-verify/{id}',[LoginController::class,'register_otp_verify'])->name('seller.register_otp_verify');;

    });
 


    Route::middleware(['seller_login'])->group(function(){
    
    route::Match(['get','post'],'/store_information/{id}',[LoginController::class,'store_information'])->name('seller.store_information');
    route::Match(['get','post'],'/upload_document/{id}',[LoginController::class,'upload_document'])->name('seller.upload_document');
    route::Match(['get','post'],'/upload_summary/{id}',[LoginController::class,'upload_summary'])->name('seller.upload_review');
    route::Match(['get','post'],'/review_submit_page/{id}',[LoginController::class,'signup_review'])->name('seller.review_submit_page');    
    route::Match(['get','post'],'/logout',[LoginController::class,'logout'])->name('seller.logout');    

    
    });
    



    route::Match(['get','post'],'/verify-otp',[LoginController::class,'verify_otp']);
    route::Match(['get','post'],'/forgot_password',[LoginController::class,'forgot_password'])->name('seller.forgot');
    route::Match(['get','post'],'/reset_password/{id}',[LoginController::class,'reset_password'])->name('seller.create_password');


    route::Match(['get','post'],'/dashboard',[LoginController::class,'seller_dashboard'])->name('seller.dashboard');



    route::Match(['get','post'],'/removeImage',[LoginController::class,'removeImage'])->name('seller.removeImage');    






});