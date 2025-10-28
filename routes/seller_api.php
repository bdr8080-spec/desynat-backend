<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Seller\AuthController;


Route::group(['prefix' => 'seller'], function () {
    Route::post('create_account', [AuthController::class, 'create_account']);

    





});


