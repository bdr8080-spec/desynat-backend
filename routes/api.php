<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\User\AuthController;

use App\Http\Controllers\Api\User\UserDashboardController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\AddressController;
use App\Http\Controllers\Api\User\UserStoreController;
use App\Http\Controllers\Api\User\GiftCardControler;
use App\Http\Controllers\Api\User\UserOrderController;


use App\Http\Controllers\Api\User\UserChatController;

use App\Http\Controllers\CommonController;

use Illuminate\Support\Facades\Artisan;


Route::get('optimize',function(){
    Artisan::call('optimize');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return 'Application optimized successfully!';
});




require __DIR__.'/admin_api.php';
require __DIR__.'/seller_api.php';
require __DIR__.'/deliveryboy_api.php';


// User APi M1
Route::post('/register',[AuthController::class,'register']);
Route::post('/verify_otp',[AuthController::class,'verify_otp']);
Route::post('/resend_otp',[AuthController::class,'resend_otp']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/login_by_mobile_or_email',[AuthController::class,'login_by_mobile_or_email']);

route::post('/forgot_password',[AuthController::class,'forgot_password']);
route::post('/create_password',[AuthController::class,'create_password']);

// Auth Code check

Route::middleware(['auth:sanctum', 'ability:user'])->prefix('user')->group(function () {


  Route::get('/user-dashboard', [UserDashboardController::class,'index']);

  Route::get('/view-profile',[ProfileController::class, 'viewProfile']);
  Route::post('/change-password',[ProfileController::class, 'change_password']);
  Route::post('/update-profile',[ProfileController::class, 'updateProfile']);

  Route::post('/change-mobile-number', [ProfileController::class, 'changeMobileNumber']);
  Route::post('/verify-otp', [ProfileController::class, 'verifyOtp']);


  Route::get('/logout', [UserDashboardController::class,'logout']);

  Route::post('/save-address',[AddressController::class, 'saveAddress']);
  Route::put('/update-address',[AddressController::class, 'updateAddress']);
  Route::get('/view-address', [AddressController::class, 'viewAddress']);
  Route::delete('/delete-address/{id}', [AddressController::class, 'deleteAddress']);
  Route::post('/set_default_address',[AddressController::class, 'set_default_address']);


  // M3 Api User

  Route::post('/category-Wise-Store-List', [UserStoreController::class,'category_Wise_Store_List']);
  Route::post('/single-store-details', [UserStoreController::class,'single_store_details']);
  Route::post('/single-product-details', [UserStoreController::class,'single_product_details']);

  
  Route::post('/product-add-to-wishlist', [UserStoreController::class,'product_add_to_wishlist']);

  Route::post('/product-add-to-cart', [UserStoreController::class,'product_add_to_cart']);

  Route::get('/view_cart_details', [UserStoreController::class,'view_cart_details']);

  Route::post('/addtocart-increment-decrement', [UserStoreController::class,'addtocart_increment_decrement']);

  Route::get('/get_wishlist_products', [UserStoreController::class,'get_wishlist_products']);


  // M4 APis start 


  Route::get('/gift-card-occasion-list', [GiftCardControler::class,'gift_card_occasion']);

  Route::post('/add-gift-card', [GiftCardControler::class,'user_add_gift_card']);

  Route::post('/giftcard-complete-Payment', [GiftCardControler::class,'giftcard_complete_Payment']);

  Route::post('/view-gift-cards', [GiftCardControler::class,'view_gift_cards']);

  Route::post('/view-promocode-list', [UserOrderController::class,'View_promocode_list']);
  Route::post('/Apply-promocode', [UserOrderController::class,'Apply_promocode']);

  Route::post('/create-order', [UserOrderController::class,'create_order']);

  Route::post('/apply-gift-card', [UserOrderController::class,'apply_gift_card']);


  Route::post('/product-order-complete-payment', [UserOrderController::class,'product_order_complete_payment']);

  Route::get('/waller-balance',[UserOrderController::class, 'waller_balance']);

  // M5 APi 
  
  Route::post('/All-order', [UserOrderController::class,'All_order']);
  Route::post('/single-order-summary', [UserOrderController::class,'single_order_summary']);

  Route::post('/get-reject-reason', [UserOrderController::class,'get_reject_reason']);

  // cancelled full order 
  Route::post('/cancelled-single-product', [UserOrderController::class,'cancelled_single_product']);

  Route::post('/return-product-after-delivered', [UserOrderController::class,'return_product_after_delivered']);
  Route::post('/exchange-product-after-delivered', [UserOrderController::class,'exchange_product_after_delivered']);

  Route::post('/return-exchange-product-after-delivered', [UserOrderController::class,'return_exchange_product_after_delivered']);

  Route::post('/product-rating', [UserOrderController::class,'product_rating']);
  Route::post('/home-page-search', [UserDashboardController::class,'home_page_search']);
  Route::get('/get-recent-search-data', [UserDashboardController::class,'get_recent_search_data']);
  Route::get('/get-latest-search-data', [UserDashboardController::class,'get_recent_search_data']);
  
  Route::get('/get-recommnded-search-data', [UserDashboardController::class,'get_recommanded_search_data']);

  Route::post('/get-Invoice', [UserDashboardController::class,'get_Invoice']);

  // M6 APi 
  Route::post('/create-Custom-order', [UserChatController::class,'create_Custom_order']);
  Route::post('/send-custom-order-request', [UserChatController::class,'send_custom_order_request']);

  Route::post('/user-all-chats', [UserChatController::class,'userAllChats']);

  Route::post('/user-Single-chats', [UserChatController::class,'userSinglechats']);


});

Route::post('/send-message-in-chats', [UserChatController::class,'SendMessageInChats']);


Route::post('/get-Invoice', [UserDashboardController::class,'get_Invoice']);


Route::get('/store_filter', [UserStoreController::class,'store_filter']);

Route::get('user/category',[ProfileController::class, 'getCategories']);
Route::get('user/sub-category',[ProfileController::class, 'getSubCategories']);

// common APi

Route::post('upload', [CommonController::class, 'upload']);
Route::get('country', [CommonController::class, 'country']);
Route::get('all_country', [CommonController::class, 'all_country']);


Route::get('category',[CommonController::class, 'getCategories']);
Route::get('sub-category',[CommonController::class, 'getSubCategories']);
Route::get('all-brand',[CommonController::class, 'get_brand']);

Route::get('all-color',[CommonController::class, 'get_color']);
Route::get('all-size',[CommonController::class, 'get_size']);