<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Seller\LoginController;
use App\Http\Controllers\Seller\WebSellerDashboard;
use App\Http\Controllers\Seller\SellerProductController;



Route::group(['prefix' => 'seller'], function () {


    Route::middleware(['is_seller','prevent-back-history'])->group(function(){
        
    route::Match(['get','post'],'/login',[LoginController::class,'login'])->name('seller.login');
    route::Match(['get','post'],'/register',[LoginController::class,'register'])->name('seller.register');

    route::Match(['get','post'],'/otp-verify/{id}',[LoginController::class,'register_otp_verify'])->name('seller.register_otp_verify');;

    });
 


    Route::middleware(['seller_login','prevent-back-history'])->group(function(){
    
    route::Match(['get','post'],'/store_information/{id}',[LoginController::class,'store_information'])->name('seller.store_information');
    route::Match(['get','post'],'/upload_document/{id}',[LoginController::class,'upload_document'])->name('seller.upload_document');
    route::Match(['get','post'],'/upload_summary/{id}',[LoginController::class,'upload_summary'])->name('seller.upload_review');
    route::Match(['get','post'],'/review_submit_page/{id}',[LoginController::class,'signup_review'])->name('seller.review_submit_page');    
    route::Match(['get','post'],'/logout',[LoginController::class,'logout'])->name('seller.logout');    

    route::Match(['get','post'],'/dashboard',[WebSellerDashboard::class,'seller_dashboard'])->name('seller.dashboard');

    route::Match(['get','post'],'/all-plans',[WebSellerDashboard::class,'all_plans'])->name('seller.all_plans');
    route::Match(['get','post'],'/single-plans/{id}',[WebSellerDashboard::class,'single_plans'])->name('seller.single_plans');
    
    route::Match(['get','post'],'/create-subcription',[WebSellerDashboard::class,'create_subcription'])->name('seller.create_subcription');
  

    route::Match(['get','post'],'/skip-plan',[WebSellerDashboard::class,'skip_plan'])->name('seller.skip_plan');
  

    route::Match(['get','post'],'/products',[SellerProductController::class,'products'])->name('seller.products');
    route::Match(['get','post'],'/Inventory-Management',[SellerProductController::class,'Inventory_Management'])->name('seller.Inventory_Management');
    route::Match(['get','post'],'/Affilate-Commission',[SellerProductController::class,'Affilate_Commission'])->name('seller.Affilate_Commission');

    route::get('/Add-product',[SellerProductController::class,'Add_product'])->name('seller.Add_product');
    Route::post('add-product',[SellerProductController::class, 'Add_product_code'])->name('seller.Add_product_code');

    route::Match(['get','post'],'/view-product/{id}',[SellerProductController::class,'view_product'])->name('seller.view_product');

    route::Match(['get','post'],'/edit-product/{id}',[SellerProductController::class,'edit_product'])->name('seller.edit-product');
    // route::Match(['get','post'],'/view-profile',[SellerProductController::class,'view_profile'])->name('seller.view_profile');
    // M3 Milestone Work

     Route::post('Update-product/{id}',[SellerProductController::class, 'edit_product_code'])->name('seller.edit_product_code');

    
    route::Match(['get','post'],'/web_store_on_off',[WebSellerDashboard::class,'web_store_on_off'])->name('seller.web_store_on_off');

    Route::get('product-status-active-inactive',[SellerProductController::class, 'product_status_active_inactive']);

    



    });
    


    route::Match(['get','post'],'/verify-otp',[LoginController::class,'verify_otp']);
    route::Match(['get','post'],'/forgot_password',[LoginController::class,'forgot_password'])->name('seller.forgot');
    route::Match(['get','post'],'/reset_password/{id}',[LoginController::class,'reset_password'])->name('seller.create_password');


    route::Match(['get','post'],'/removeImage',[LoginController::class,'removeImage'])->name('seller.removeImage');    






});


route::Match(['get','post'],'/view-profile', function(){
    return view('dealer.product.view_profile');
});



Route::fallback(function () {

    return view('404');
});