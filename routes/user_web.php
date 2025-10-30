<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;



 Route::group(['prefix' => 'user'], function () { 

    Route::match(['get','post'],'/login',[AuthController::class,'userLogin']);
    Route::match(['get','post'],'/register',[AuthController::class,'userRegister'])->name('userRegister');
    route::match(['get','post'],'/forgot-password',[AuthController::class,'userForgetPassword']);
    Route::match(['get','post'],'/verify-otp',[AuthController::class,'userVerifyOtp']);
    route::match(['get','post'],'/create-password',[AuthController::class,'userCreatePassword']);

 });