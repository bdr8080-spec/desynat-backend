<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Seller\AuthController;


Route::group(['prefix' => 'seller'], function () {
    Route::post('create_account', [AuthController::class, 'create_account']);
    Route::post('/verify_otp',[AuthController::class,'verify_otp']);


Route::post('/store_information', [AuthController::class,'store_information']);
Route::post('/store_document_and_bank_details', [AuthController::class,'store_document_and_bank_details']);

Route::post('/seller_review', [AuthController::class,'seller_review']);

Route::post('/seller_store_submit_request', [AuthController::class,'seller_store_submit_request']);

Route::post('/login',[AuthController::class,'login']);

route::post('/forgot_password',[AuthController::class,'forgot_password']);
route::post('/create_password',[AuthController::class,'create_password']);




Route::group(['middleware'=>['auth:sanctum']], function(){



});






});


