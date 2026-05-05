<?php

use App\Http\Controllers\User\UserAffilatedController;
use App\Http\Controllers\User\UserAffiliatedProfileController;

use App\Http\Controllers\SaveFirebaseToken;

// Save Admin firebase Token 

Route::get('affiliate-save-token', [SaveFirebaseToken::class, 'saveAffiliateToken']);


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


//  Affilate profile code 

Route::match(['get', 'post'], '/affiliate-profile', [UserAffiliatedProfileController::class, 'affiliateProfile'])->name('affiliate.affiliateProfile');
Route::match(['get', 'post'], '/affiliate/change-password', [UserAffiliatedProfileController::class, 'affiliateChangePassword'])->name('affiliate.change-password');

Route::match(['get', 'post'], '/affiliate-save-profile', [UserAffiliatedProfileController::class, 'affiliateSaveProfile'])->name('affiliate.affiliatesaveprofile');

Route::match(['get', 'post'], '/affiliate-profile-address', [UserAffiliatedProfileController::class, 'affiliateProfilesaveAddress'])->name('affiliate.affiliateProfilesaveAddress');


// Route::match(['get', 'post'], '/affiliate-verify-otp', [UserAffiliatedProfileController::class, 'affiliateaffiliateVerifyOtp'])->name('affiliate.affiliateaffiliateVerifyOtp');
// Route::match(['get', 'post'], '/change-number-or-email', [UserAffiliatedProfileController::class, 'affiliatechangeNumberAndemail'])->name('affiliate.affiliatechangeNumberAndemail');

Route::match(['get', 'post'], '/old-number-send-otp', [UserAffiliatedProfileController::class, 'oldNumberSendOtp'])->name('affiliate.userOldNumberSendOtp');
Route::match(['get', 'post'], '/verify-contact-otp', [UserAffiliatedProfileController::class, 'oldNumberVerify'])->name('affiliate.userOldNumberVerify');
Route::match(['get','post'], '/update-new-number', [UserAffiliatedProfileController::class, 'updateNewNumber'])->name('affiliate.userUpdateNewNumber');
Route::match(['get','post'],'/update-email-address',[UserAffiliatedProfileController::class, 'updateEmailAddress'])->name('affiliate.userUpdateNewEmail');
Route::get('/update-resend-otp', [UserAffiliatedProfileController::class, 'updateResendOtp'])->name('affiliate.updateResendOtp');




// My Affilate prosduct Show Code 
Route::match(['get', 'post'], '/affiliate/my-product', [UserAffiliatedProfileController::class, 'affiliateMyProduct'])->name('affiliate.affiliateMyProduct');
Route::get('/affiliate/my-product-subcategory', [UserAffiliatedProfileController::class, 'myProductFiltersubcategory'])
    ->name('affiliate.myProductFiltersubcategory');
Route::get('/affiliate/my-product-filter', [UserAffiliatedProfileController::class, 'myProductFilter'])
    ->name('affiliate.Myproductfilter');

Route::get('/affiliate/affiliate-product-performance/{id}', [UserAffiliatedProfileController::class, 'affiliateProductPerformance'])->name('affiliate.ProductPerformance');

Route::post('/affiliate/updateBankAccountDetails/{id}', [UserAffiliatedProfileController::class, 'updateBankAccountDetails'])->name('affiliate.updateBankAccountDetails');
Route::post('/affiliate/addAnotherBankDetails', [UserAffiliatedProfileController::class, 'addAnotherBankDetails'])->name('affiliate.addAnotherBankDetails');
Route::post('/affiliate/deleteBankAccount/{id}', [UserAffiliatedProfileController::class, 'deleteBankAccount'])->name('affiliate.deleteBankAccount');


// catgeory Code 
Route::match(['get', 'post'], '/affiliate/category', [UserAffiliatedProfileController::class, 'affiliateMyCategory'])->name('affiliate.affiliateCategory');

Route::get('/affiliate/allsubcategory', [UserAffiliatedProfileController::class, 'Affilateallsubcategory'])
    ->name('affiliate.allsubcategory');

Route::get('/affiliate/all-products', [UserAffiliatedProfileController::class, 'AffilateAllProducts'])
    ->name('affiliate.allProducts');

Route::get('/affiliate/generate-product-link', [UserAffiliatedProfileController::class, 'generateProductLink'])
    ->name('affiliate.generateProductLink');
    
Route::post('/affiliate/add_to_my_products', [UserAffiliatedProfileController::class, 'add_to_my_products'])
->name('affiliate.add_to_my_products');

//m9
Route::get('/affiliate/payment', [UserAffilatedController::class, 'payment'])->name('affiliate.payment');
Route::get('/affiliate/my-withdrawals', [UserAffilatedController::class, 'myWithdrawls'])->name('affiliate.myWithdrawls');
Route::post('/affiliate/affiliate_submit_withdraw_request', [UserAffilatedController::class, 'affiliate_submit_withdraw_request'])->name('affiliate.affiliate_submit_withdraw_request');

//m10
Route::post('/mark_notification_as_read', [UserAffilatedController::class, 'mark_notification_as_read'])->name('affiliate.mark_notification_as_read');

//m12
Route::get('/affiliate/ticket-management', [UserAffilatedController::class, 'ticket_management'])->name('affiliate.ticket_management');
Route::post('/affiliate/raise_ticket', [UserAffilatedController::class, 'raise_ticket'])->name('affiliate.raise_ticket');

Route::post('/delete_affiliate_account', [UserAffilatedController::class, 'delete_affiliate_account'])->name('affiliate.delete_affiliate_account');

// });

Route::get('affiliate/about-us', [UserAffilatedController::class, 'aboutUs'])->name('affiliate.aboutUs');
Route::get('affiliate/terms-conditions', [UserAffilatedController::class, 'termCondition'])->name('affiliate.termCondition');
Route::get('affiliate/return-policy', [UserAffilatedController::class, 'returnPolicy'])->name('affiliate.returnPolicy');
Route::get('affiliate/exchange-policy', [UserAffilatedController::class, 'exchangePolicy'])->name('affiliate.exchangePolicy');
Route::get('affiliate/cancellation-policy', [UserAffilatedController::class, 'cancellationPolicy'])->name('affiliate.cancellationPolicy');
Route::get('affiliate/faq', [UserAffilatedController::class, 'faq'])->name('affiliate.faq');

Route::get('affiliate/setting', [UserAffilatedController::class, 'setting'])->name('affiliate.setting');
Route::post('affiliate/affiliate_notification_on_off', [UserAffilatedController::class, 'affiliate_notification_on_off'])->name('affiliate.affiliate_notification_on_off');
Route::post('affiliate/affiliate_app_notification_on_off', [UserAffilatedController::class, 'affiliate_app_notification_on_off'])->name('affiliate.affiliate_app_notification_on_off');









































//  Affiliate_user profile

// Route::match(['get', 'post'], '/profile', function () {
//     return view('affiliatedUser.profiles.profile');

// })->name('affiliatedUser.profile');

// Route::match(['get', 'post'], '/change-password', function () {
//     return view('affiliatedUser.profiles.change-pwd');

// })->name('affiliatedUser.change-password');

// Route::match(['get', 'post'], '/category', function () {
//     return view('affiliatedUser.category.categorys');

// })->name('affiliatedUser.category');

Route::match(['get', 'post'], '/all-product', function () {
    return view('affiliatedUser.category.allproducts');

})->name('affiliatedUser.all-product');

Route::match(['get', 'post'], '/my-product', function () {
    return view('affiliatedUser.myproducts.my-products');

})->name('affiliatedUser.my-product');

// Route::match(['get', 'post'], '/all-performance', function () {
//     return view('affiliatedUser.myproducts.performance');

// })->name('affiliatedUser.all-performance');

Route::match(['get', 'post'], '/change-mobile-number', function () {
    return view('affiliatedUser.profiles.change-mobile');

})->name('affiliatedUser.change-mobile-number');