<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DeliveryBoy\AuthController;

use App\Http\Controllers\Api\DeliveryBoy\DeliveryBoyDashboardController;


// M1 Milestone 
Route::group(['prefix' => 'deliveryboy'], function () {
    Route::post('/verify_otp',[AuthController::class,'verify_otp']);
    Route::post('/resend_otp',[AuthController::class,'resend_otp']);
    Route::post('/login',[AuthController::class,'login']);
    route::post('/forgot_password',[AuthController::class,'forgot_password']);
    route::post('/create_password',[AuthController::class,'create_password']);

    // Auth Checking
    Route::middleware(['auth:sanctum', 'ability:delivery-boy'])->group(function () {

    Route::get('/delivery_boy_dashboard', [DeliveryBoyDashboardController::class,'index']);

    Route::get('/logout', [DeliveryBoyDashboardController::class,'logout']);
    Route::get('/delivery_boy_profile', [DeliveryBoyDashboardController::class,'delivery_boy_profile']);



    });






});