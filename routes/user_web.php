<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;



  Route::get('/', [AuthController::class,'dashboard'])->name('dashboard');

 Route::group(['prefix' => 'user'], function () { 

  Route::group(['middleware' => 'guest_user'], function () {
    Route::match(['get', 'post'], '/login', [AuthController::class, 'userLogin'])->name('userLogin');
    Route::match(['get', 'post'], '/register', [AuthController::class, 'userRegister'])->name('userRegister');
    Route::match(['get', 'post'], '/forgot-password', [AuthController::class, 'userForgetPassword'])->name('userForgetPassword');
    Route::match(['get', 'post'], '/verify-otp', [AuthController::class, 'userVerifyOtp'])->name('userVerifyOtp');
    Route::match(['get', 'post'], '/create-password', [AuthController::class, 'userCreatePassword'])->name('userCreatePassword');
    Route::match(['get', 'post'], '/login-with-otp', [AuthController::class, 'loginWithOtp'])->name('loginWithOtp');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('userResendOtp');
});

   
   Route::get('/prfoile', [ProfileController::class, 'useProfile'])->name('useProfile');
   Route::get('/logout',[AuthController::class,'userLogout'])->name('userLogout');


 });