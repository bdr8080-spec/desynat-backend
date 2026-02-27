<?php

use App\Http\Controllers\User\UserAffilatedController;
use App\Http\Controllers\User\UserAffiliatedProfileController;


 Route::group(['prefix' => 'user','middleware'=>['Affiliate_user']  ], function () { 

//   M7 APis 
Route::get('/affiliate-start-page', [UserAffilatedController::class,'affiliate_startPage'])->name('affiliate.affiliate_startPage');

Route::match(['get','post'],'/affiliate-login', [UserAffilatedController::class,'affiliate_login'])->name('affiliate.affiliate_login');
Route::match(['get', 'post'], '/affiliate-login-with-otp', [UserAffilatedController::class, 'affiliate_loginWithOtp'])->name('affiliate_loginWithOtp');
Route::match(['get','post'],'/affiliate-verify-otp', [UserAffilatedController::class,'affiliate_otpVerify'])->name('affiliate.affiliate_otpVerify');
Route::match(['get', 'post'], '/affiliate-forgot-password', [UserAffilatedController::class, 'affiliate_forgotpassword'])->name('affiliate_forgotpassword');
Route::match(['get', 'post'], '/affiliate-create-password', [UserAffilatedController::class, 'userCreatePassword'])->name('affiliate.userCreatePassword');  
Route::match(['get', 'post'], '/affiliate-signup', [UserAffilatedController::class, 'affiliate_signup'])->name('affiliate.affiliate_signup');

Route::post('/resend-otp', [UserAffilatedController::class, 'resendOtp'])->name('affiliate_signupResendOtp');


});

//  Route::group(['middleware'=>['Affiliate_user']  ], function () { 

// M7 Code 
 Route::get('/logout',[UserAffilatedController::class,'userLogout'])->name('affiliateLogout');

 Route::match(['get','post'],'/affiliate-add-address', [UserAffilatedController::class,'affiliate_addaddress'])->name('affiliate.affiliate_addaddress');

 Route::match(['get','post'],'/affiliate-add-Bank-details', [UserAffilatedController::class,'affiliateAddBankDetails'])->name('affiliate.affiliateAddBankDetails');
 
 Route::match(['get','post'],'/review_submit_page', [UserAffilatedController::class,'affiliatereview_submit_page'])->name('affiliate.affiliatereview_submit_page');
   
//  Affiliate_user

 Route::get('/affiliate-dashboard', [UserAffilatedController::class,'affiliateDashboard'])->name('affiliate.affiliateDashboard');
 Route::match(['get', 'post'], '/affiliate-reverify-Document', [UserAffilatedController::class, 'affiliatereverifyDocument'])->name('affiliate.affiliatereverifyDocument');


Route::match(['get', 'post'], '/affiliate-profile', [UserAffiliatedProfileController::class, 'affiliateProfile'])->name('affiliate.affiliateProfile');




// });


//  Affiliate_user profile

Route::match(['get', 'post'], '/profile', function () {
    return view('affiliatedUser.profiles.profile');

})->name('affiliatedUser.profile');

Route::match(['get', 'post'], '/change-password', function () {
    return view('affiliatedUser.profiles.change-pwd');

})->name('affiliatedUser.change-password');

Route::match(['get', 'post'], '/category', function () {
    return view('affiliatedUser.category.categorys');

})->name('affiliatedUser.category');

Route::match(['get', 'post'], '/all-product', function () {
    return view('affiliatedUser.category.allproducts');

})->name('affiliatedUser.all-product');

Route::match(['get', 'post'], '/my-product', function () {
    return view('affiliatedUser.myproducts.my-products');

})->name('affiliatedUser.my-product');

Route::match(['get', 'post'], '/all-performance', function () {
    return view('affiliatedUser.myproducts.performance');

})->name('affiliatedUser.all-performance');