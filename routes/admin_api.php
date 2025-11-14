<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\BrandController;
use App\Http\Controllers\Api\Admin\SellerController;
use App\Http\Controllers\Api\Admin\CountryController;
use App\Http\Controllers\Api\Admin\PlanController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ReasonController;
use App\Http\Controllers\Api\Admin\DeliveryBoyController;


// Admin APi M1
Route::group(['prefix' => 'admin'], function () {   
    Route::post('/admin_login',[AuthController::class,'admin_login']);
    Route::post('/admin_forgot_password',[AuthController::class,'admin_forgot_password']);
    Route::post('/admin_verify_otp',[AuthController::class,'admin_verify_otp']);
    Route::post('/admin_create_password',[AuthController::class,'admin_create_password']);
    Route::post('/resend_otp',[AuthController::class,'resend_otp']);
    
    Route::get('/get_countries',[CountryController::class,'get_countries']);


   Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {

      //Logout
      Route::post('/admin_logout',[AuthController::class,'admin_logout']);

      //Category and sub category
      Route::get('/get_category',[CategoryController::class,'get_category']);
      Route::get('/get_subcategories',[CategoryController::class,'get_subcategories']);
      Route::post('/change_category_status',[CategoryController::class,'change_category_status']);
      Route::post('/change_subcategory_status',[CategoryController::class,'change_subcategory_status']);
      Route::post('/add_subcategory',[CategoryController::class,'add_subcategory']);
      Route::post('/update_subcategory',[CategoryController::class,'update_subcategory']);
      Route::post('/delete_subcategory',[CategoryController::class,'delete_subcategory']);

      //Brand
      Route::get('/get_brand',[BrandController::class,'get_brand']);
      Route::post('/change_brand_status',[BrandController::class,'change_brand_status']);
      Route::post('/add_brand',[BrandController::class,'add_brand']);
      Route::post('/update_brand',[BrandController::class,'update_brand']);
      Route::post('/delete_brand',[BrandController::class,'delete_brand']);
      //M1 api ends

     //M2 Api Starts

     //Seller management
     Route::get('/get_new_sellers',[SellerController::class,'get_new_sellers']);
     Route::get('/get_approved_sellers',[SellerController::class,'get_approved_sellers']);
     Route::get('/get_rejected_sellers',[SellerController::class,'get_rejected_sellers']);
     Route::get('/get_seller_details',[SellerController::class,'get_seller_details']);
     Route::post('/accept_seller',[SellerController::class,'accept_seller']);
     Route::post('/reject_seller',[SellerController::class,'reject_seller']);
     Route::post('/block_unblock_seller',[SellerController::class,'block_unblock_seller']);

     //country,city,zone management
     Route::get('/get_cities',[CountryController::class,'get_cities']);
     Route::get('/get_service_cities',[CountryController::class,'get_service_cities']);
     Route::post('/add_service_city',[CountryController::class,'add_service_city']);
     Route::post('/change_service_city_status',[CountryController::class,'change_service_city_status']);
     Route::post('/delete_service_city',[CountryController::class,'delete_service_city']);
     Route::get('/get_zones',[CountryController::class,'get_zones']);
     Route::get('/get_zone_details',[CountryController::class,'get_zone_details']);
     Route::post('/add_zone',[CountryController::class,'add_zone']);
     Route::post('/update_zone',[CountryController::class,'update_zone']);
     Route::post('/change_zone_status',[CountryController::class,'change_zone_status']);
     Route::post('/delete_zone',[CountryController::class,'delete_zone']);

     //Plan Management
     Route::post('/add_plan',[PlanController::class,'add_plan']);
     Route::post('/update_plan',[PlanController::class,'update_plan']);
     Route::get('/get_plans',[PlanController::class,'get_plans']);
     Route::get('/get_plan_details',[PlanController::class,'get_plan_details']);
     Route::post('/change_plan_status',[PlanController::class,'change_plan_status']);
     Route::post('/delete_plan',[PlanController::class,'delete_plan']);
     
     //M2 api ends

     //M3 api starts

     //user management
     Route::get('/get_users',[UserController::class,'getUsers']);
     Route::get('/get_user_countries_list',[UserController::class,'get_user_countries_list']);
     Route::get('/get_user_details',[UserController::class,'get_user_details']);
     Route::post('/block_unblock_user',[UserController::class,'block_unblock_user']);
     Route::post('/add_user_wallet_amount',[UserController::class,'add_user_wallet_amount']);

     //reason management
     Route::get('/get_reasons',[ReasonController::class,'get_reasons']);
     Route::post('/change_reason_status',[ReasonController::class,'change_reason_status']);
     Route::post('/add_reason',[ReasonController::class,'add_reason']);
     Route::post('/update_reason',[ReasonController::class,'update_reason']);
     Route::post('/delete_reason',[ReasonController::class,'delete_reason']);

     //delivery boy management
     Route::get('/get_delivery_boys',[DeliveryBoyController::class,'getDeliveryBoys']);
     Route::get('/get_deliveryboy_details',[DeliveryBoyController::class,'get_deliveryboy_details']);
     Route::post('/block_unblock_deliveryboy',[DeliveryBoyController::class,'block_unblock_deliveryboy']);
     Route::post('/delete_deliveryboy',[DeliveryBoyController::class,'delete_deliveryboy']);





   });


});


