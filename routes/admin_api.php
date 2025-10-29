<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\BrandController;


// Admin APi M1
 Route::group(['prefix' => 'admin'], function () {   
    Route::post('/admin_login',[AuthController::class,'admin_login']);
    route::post('/admin_forgot_password',[AuthController::class,'admin_forgot_password']);
    Route::post('/admin_verify_otp',[AuthController::class,'admin_verify_otp']);
    route::post('/admin_create_password',[AuthController::class,'admin_create_password']);



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





    });


});


