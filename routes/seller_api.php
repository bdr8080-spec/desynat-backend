<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Seller\AuthController;

use App\Http\Controllers\Api\Seller\SellerDashboardController;

use App\Http\Controllers\Api\Seller\SellerProductController;


use App\Http\Controllers\CommonController;


// M1 Milestone 
Route::group(['prefix' => 'seller'], function () {
    Route::post('create_account', [AuthController::class, 'create_account']);
    Route::post('/verify_otp',[AuthController::class,'verify_otp']);
    Route::post('/resend_otp',[AuthController::class,'resend_otp']);


Route::post('/store_information', [AuthController::class,'store_information']);
Route::post('/store_document_and_bank_details', [AuthController::class,'store_document_and_bank_details']);

Route::post('/seller_review', [AuthController::class,'seller_review']);

Route::post('/seller_store_submit_request', [AuthController::class,'seller_store_submit_request']);

Route::post('/login',[AuthController::class,'login']);

route::post('/forgot_password',[AuthController::class,'forgot_password']);
route::post('/create_password',[AuthController::class,'create_password']);

// Auth Checking
Route::middleware(['auth:sanctum', 'ability:seller'])->group(function () {

  Route::post('/seller-dashboard', [SellerDashboardController::class,'index']);

  Route::get('/logout', [SellerDashboardController::class,'logout']);

  Route::get('/all-plans', [SellerDashboardController::class,'all_plans']);

  Route::get('/single-plans-show/{id}', [SellerDashboardController::class,'single_plans_show']);


  Route::post('/create-subcription-plan-buy', [SellerDashboardController::class,'create_subcription_plan_buy']);

  Route::post('/payment-subcription-plan', [SellerDashboardController::class,'payment_subcription_plan']);

  Route::post('/seller-profile', [SellerDashboardController::class,'seller_profile']);

  // M3 Api 

    Route::get('/store_on_off', [SellerDashboardController::class,'store_on_off']);

    Route::get('category',[CommonController::class, 'getCategories']);
    Route::get('sub-category',[CommonController::class, 'getSubCategories']);
    Route::get('all-brand',[CommonController::class, 'get_brand']);

    Route::get('all-color',[CommonController::class, 'get_color']);
    Route::get('all-size',[CommonController::class, 'get_size']);


    
    Route::post('add-product',[SellerProductController::class, 'add_product']);
        
    Route::post('all-product',[SellerProductController::class, 'all_product']);

    Route::post('single-product-details',[SellerProductController::class, 'single_product_details']);

    Route::put('product-status-active-inactive',[SellerProductController::class, 'product_status_active_inactive']);

    Route::delete('product-delete',[SellerProductController::class, 'product_delete']);

});






});


Route::get('/upload_color', [SellerDashboardController::class,'upload_color']);

Route::get('/all_color', [SellerDashboardController::class,'upload_color']);