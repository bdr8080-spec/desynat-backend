<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserStoreController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\UserGiftCardController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\DashBoardController;
use App\Http\Controllers\User\ChatController;





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

   Route::post('create_order',[CartController::class, 'create_order'])->name('user.create_order');


  Route::get('complete-order-Payment',[CartController::class, 'complete_order_Payment'])->name('user.complete_order_Payment');

  Route::get('order-details/{id}',[CartController::class, 'orderDetails'])->name('user.orderDetails');


  Route::get('/giftcard-complete-Payment', [UserGiftCardController::class,'giftcard_complete_Payment'])->name('user.giftcard_complete_Payment');

  Route::get('/my-orders', [OrderController::class,'myOrders'])->name('user.myOrders');
  Route::get('/order_details/{id}', [OrderController::class,'order_details'])->name('user.order_details');
  Route::post('/cancel_order', [OrderController::class,'cancel_order'])->name('user.cancel_order');
  Route::post('/exchange_order', [OrderController::class,'exchange_order'])->name('user.exchange_order');
  Route::post('/getAvailableSize', [OrderController::class,'getAvailableSize'])->name('user.getAvailableSize');
  Route::post('/return_order', [OrderController::class,'return_order'])->name('user.return_order');
  Route::post('/submitRating', [OrderController::class,'submitRating'])->name('user.submitRating');

  Route::get('/all-product', [UserStoreController::class,'all_product'])->name('user.allproduct');

  Route::get('/chat', [ChatController::class,'allChats'])->name('user.allChats');
  Route::get('/user-chat/{id}', [ChatController::class,'userChat'])->name('user.userChat');
  Route::get('/chat-details', [ChatController::class,'chatDetails'])->name('user.chatDetails');
  Route::post('/sendNormalMessage', [ChatController::class,'sendNormalMessage'])->name('user.sendNormalMessage');
  Route::get('/custom-request', [ChatController::class,'customRequest'])->name('user.customRequest');
  Route::post('/createCustomOrder', [ChatController::class,'createCustomOrder'])->name('user.createCustomOrder');
  Route::post('/sendCustomOrderRequest', [ChatController::class,'sendCustomOrderRequest'])->name('user.sendCustomOrderRequest');

});



Route::get('Payment-Callback',[CartController::class, 'Payment_Callback'])->name('user.Payment_Callback');
Route::post('/headerSearch', [DashBoardController::class, 'headerSearch'])->name('user.headerSearch');
Route::get('/getSearchData', [DashBoardController::class, 'getSearchData'])->name('user.getSearchData');

Route::get('/getRecommandedlatestSearch', [DashBoardController::class, 'getRecommandedlatestSearch'])->name('user.getRecommandedlatestSearch');

Route::get('/getlatestSearch', [DashBoardController::class, 'getlatestSearch'])->name('user.getlatestSearch');





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

// Route::match(['get', 'post'], '/chat', function () {
//      return view('user.chat.chatlists');

// })->name('user.chat');

// Route::match(['get', 'post'], '/user-chat', function () {
//      return view('user.chat.userChat');

// })->name('user.user-chat');

// Route::match(['get', 'post'], '/details-chat', function () {
//      return view('user.chat.detailsChat');
     
// })->name('user.details-chat');

// Route::match(['get', 'post'], '/order_details', function () {
//      return view('user.orders.order-details');

// })->name('user.order_details');


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

Route::fallback(function (Request $request) {
    $uri = $request->getRequestUri();

    if (str_starts_with($uri, '/User') || preg_match('/\/[A-Z]/', $uri)) {
        return redirect(strtolower($uri), 301);
    }

    abort(404);
});