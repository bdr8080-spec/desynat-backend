<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;



// Admin APi M1
    
    Route::post('/admin_login',[AuthController::class,'admin_login']);
    route::post('/admin_forgot_password',[AuthController::class,'admin_forgot_password']);
    Route::post('/admin_verify_otp',[AuthController::class,'admin_verify_otp']);
    route::post('/admin_create_password',[AuthController::class,'admin_create_password']);



    Route::group(['prefix' => 'admin'], function () {






    });


