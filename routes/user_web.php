<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserStoreController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\UserGiftCardController;
use App\Http\Controllers\User\CartController;





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

   Route::match(['get','post'],'/category-wise-store/{id?}', [UserStoreController::class, 'category_wise_store'])->name('user.category_wise_store');

   Route::get('addOremovewishlist', [UserStoreController::class, 'AddOrRemove_wishlist'])->name('user.AddOrRemove_wishlist');
   
   Route::get('product/detail-page/{id}', [UserStoreController::class, 'productDetails'])->name('user.product_details');
  
   Route::get('wishlist',[UserStoreController::class, 'wishList'])->name('user.wishList');

   Route::get('view-address', [AddressController::class, 'viewAddress'])->name('user.view_address');
  
   Route::match(['get','post'],'save-address', [AddressController::class, 'saveAddress'])->name('user.save_address');

   Route::post('addToCart',[UserStoreController::class, 'addToCart'])->name('user.addToCart');
 

   Route::get('edit-address/{id}', [AddressController::class, 'updateAddress'])->name('user.update_address');

   Route::get('delete-address/{id}', [AddressController::class, 'deleteAddress'])->name('user.delete_address');

   Route::get('address/set-default',[AddressController::class, 'addressSetDefault'])->name('user.address_set_default');


   Route::get('gift-cards',[UserGiftCardController::class, 'gift_cards'])->name('user.gift_cards');
   Route::get('view-gift-cards/{id}',[UserGiftCardController::class, 'view_gift_card'])->name('user.view_gift_card');
   Route::get('add-gift-cards',[UserGiftCardController::class, 'add_gift_cards'])->name('user.add_gift_cards');
   Route::post('buyGiftCard',[UserGiftCardController::class, 'buyGiftCard'])->name('user.buyGiftCard');


   Route::get('view-cart',[CartController::class, 'view_cart'])->name('user.view_cart');
   Route::post('apply_promocode',[CartController::class, 'apply_promocode'])->name('user.apply_promocode');
   Route::post('apply_giftcard',[CartController::class, 'apply_giftcard'])->name('user.apply_giftcard');
   Route::post('create_order',[CartController::class, 'create_order'])->name('user.create_order');
   Route::get('order-details/{id}',[CartController::class, 'orderDetails'])->name('user.orderDetails');







});



Route::get('Payment-Callback',[CartController::class, 'Payment_Callback'])->name('user.Payment_Callback');



 Route::match(['get', 'post'], '/route1', function () {
     return view('user.category.index');
});
Route::match(['get', 'post'], '/route2', function () {
     return view('user.category.store');
});
Route::match(['get', 'post'], '/product-store-details', function () {
     return view('user.category.product-store-details');
});
Route::match(['get', 'post'], '/add-new-address', function () {
     return view('user.profile.add-new-address');
});
Route::match(['get', 'post'], '/saved-address', function () {
     return view('user.profile.saved-address');
});


Route::match(['get', 'post'], '/order-place', function () {
     return view('user.carts.orderplace');

})->name('user.order-place');

// Route::match(['get', 'post'], '/view-cart', function () {

//      return view('user.carts.cartlist');
// })->name('user.view-cart');


// Route::match(['get', 'post'], '/wishlist', function () {
//      return view('user.profile.wishlist');
// });
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