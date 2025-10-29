<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\AuthController;

use App\Http\Controllers\User\UserDashboardController;

use App\Http\Controllers\CommonController;

require __DIR__.'/admin_api.php';
require __DIR__.'/seller_api.php';


// User APi M1
Route::post('/register',[AuthController::class,'register']);
Route::post('/verify_otp',[AuthController::class,'verify_otp']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/login_by_mobile_or_email',[AuthController::class,'login_by_mobile_or_email']);

route::post('/forgot_password',[AuthController::class,'forgot_password']);
route::post('/create_password',[AuthController::class,'create_password']);

// Auth Code check

Route::middleware(['auth:sanctum', 'ability:user'])->prefix('user')->group(function () {


  Route::get('/user-dashboard', [UserDashboardController::class,'index']);

  Route::get('/logout', [UserDashboardController::class,'logout']);
  



});



// common APi
// 

Route::post('upload', [CommonController::class, 'upload']);
Route::get('country', [CommonController::class, 'country']);





