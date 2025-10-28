<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Seller\AuthController;


Route::group(['prefix' => 'seller'], function () {
    Route::post('create_account', [AuthController::class, 'create_account']);
    Route::post('/verify_otp',[AuthController::class,'verify_otp']);


// Route::group(['middleware'=>['auth:sanctum']], function(){

Route::post('/store_information', [AuthController::class,'store_information']);
Route::post('/store_document_and_bank_details', [AuthController::class,'store_document_and_bank_details']);

// });






});


