<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserStoreController;



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

   
   Route::match(['get','post'],'/profile', [ProfileController::class, 'userProfile'])->name('userProfile');
   Route::match(['get','post'],'/change-password', [ProfileController::class, 'changePassword'])->name('userChangePassword');
   Route::get('/logout',[AuthController::class,'userLogout'])->name('userLogout');

  Route::match(['get', 'post'], '/old-number-send-otp', [ProfileController::class, 'oldNumberSendOtp'])->name('userOldNumberSendOtp');
  Route::match(['get', 'post'], '/verify-contact-otp', [ProfileController::class, 'oldNumberVerify'])->name('userOldNumberVerify');
   

   Route::match(['get','post'], '/update-new-number', [ProfileController::class, 'updateNewNumber'])->name('userUpdateNewNumber');
   Route::match(['get','post'],'/update-email-address',[ProfileController::class, 'updateEmailAddress'])->name('userUpdateNewEmail');

   Route::get('/update-resend-otp', [ProfileController::class, 'updateResendOtp'])->name('updateResendOtp');

   Route::post('/save-current-location', [ProfileController::class, 'saveCurrentLocation'])->name('userSaveCurrentLocation');
   
   Route::match(['get','post'],'/store-details/{id}', [UserStoreController::class, 'store_details'])->name('user.store_details');
   
   });


 Route::match(['get', 'post'], '/route1', function () {
     return view('user.category.index');
});
Route::match(['get', 'post'], '/route2', function () {
     return view('user.category.store');
});
//  Route::match(['get', 'post'], '/route2', function () {
//      return view('user.profile.changePassword');
// });
//  Route::match(['get', 'post'], '/route3', function () {
//      return view('user.profile.profileChangeNumberOtp');
// });
//  Route::match(['get', 'post'], '/route4', function () {
//      return view('user.profile.profileChangeNumber');
// });
//  Route::match(['get', 'post'], '/route5', function () {
//      return view('user.profile.verificationCode');
// });
//  Route::match(['get', 'post'], '/route6', function () {
//      return view('user.profile.profileChangeEmailOtp');
// });