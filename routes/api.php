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
use App\Http\Controllers\Api\User\UserAffilatedControlller;
use App\Http\Controllers\Api\User\UserWalletController;

use App\Http\Controllers\Api\User\UserAffiliatedProductController;
use App\Http\Controllers\Api\User\ApiNotificationController;
use App\Http\Controllers\AgoraController;

use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Artisan;

Route::match(['get','post'],'/agora/token', [AgoraController::class, 'generateToken']);

// Route::match(['get','post'],'/agora/tokenWeb', [AgoraController::class, 'generateTokenWeb']);


Route::get('optimize',function(){
    Artisan::call('optimize');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return 'Application optimized successfully!';
});




require __DIR__.'/admin_api.php';
require __DIR__.'/seller_api.php';

require __DIR__.'/deliveryboy_api.php';


// send dummy Notification check

 Route::post('/send-notification', [ApiNotificationController::class,'sendDummynotification']);




// User APi M1
Route::post('/register',[AuthController::class,'register']);
Route::post('/verify_otp',[AuthController::class,'verify_otp']);
Route::post('/resend_otp',[AuthController::class,'resend_otp']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/login_by_mobile_or_email',[AuthController::class,'login_by_mobile_or_email']);

route::post('/forgot_password',[AuthController::class,'forgot_password']);
route::post('/create_password',[AuthController::class,'create_password']);

// Auth Code check

// // M3 Api User  
// middleware('auth:api')

Route::middleware(['optional.auth'])->prefix('user')->group(function () {

Route::post('category-Wise-Store-List', [UserStoreController::class,'category_Wise_Store_List']);
Route::post('single-store-details', [UserStoreController::class,'single_store_details']);
Route::post('single-product-details', [UserStoreController::class,'single_product_details']);

});  




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
  
  // Route::post('/category-Wise-Store-List', [UserStoreController::class,'category_Wise_Store_List']);
  // Route::post('/single-store-details', [UserStoreController::class,'single_store_details']);
  // Route::post('/single-product-details', [UserStoreController::class,'single_product_details']);

  
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

  Route::post('/user-normal-chat-with-seller', [UserChatController::class,'UserNormalChatWithSeller']);

  Route::post('/custom-create-order', [UserChatController::class,'CustomOrderCreateOrder']);

  Route::post('/custom-accept-reject-order-request', [UserChatController::class,'customAcceptRejectOrder']);

  Route::post('/custom-order-complete-payment', [UserOrderController::class,'product_order_complete_payment']);

  Route::post('/popUp-Home-screen-Banner', [UserDashboardController::class,'popUpHomescreenBanner']);

  // Client Cr Points
  
  Route::post('/custom-order-add-to-card', [UserStoreController::class,'CustomorderAddToCard']);
  Route::post('/remove-custom-product-add-to-card', [UserStoreController::class,'RemoveCustomProductAddToCard']);


  
  // M7 Api 
  Route::post('/create-a-affilated-account', [UserAffilatedControlller::class,'CreateAffilatedAccount']);
  Route::post('/affilated-verify-otp', [UserAffilatedControlller::class,'AffilatedVerifyotp']);

  Route::post('/Add-money-in-wallet', [UserWalletController::class,'AddMoneyInWallet']);

  Route::get('/wallet-history', [UserWalletController::class,'walletHistory']);

  Route::post('/redeem-gift-card-in-wallet', [UserWalletController::class,'Redeemgiftcardinwallet']);
  

  // M10 APi 

    Route::get('/user-notification', [ApiNotificationController::class,'userNotification']);

    Route::post('/read-user-notification', [ApiNotificationController::class,'ReaduserNotification']);
      
    Route::get('/user-notification', [ApiNotificationController::class,'userNotification']);
    Route::get('/count-user-notification', [ApiNotificationController::class,'CountUserNotification']);

    



    //M11
   Route::post('/add_remove_reel_to_whislist', [UserDashboardController::class,'add_remove_reel_to_whislist']);
    Route::get('/share_reel', [UserDashboardController::class,'share_reel']);
    Route::get('/get_whishlisted_reel', [UserDashboardController::class,'get_whishlisted_reel']);

    // m11 Api 
    

    //m12
    Route::post('/raise_ticket', [UserDashboardController::class,'raise_ticket']);
    Route::get('/get_raised_tickets', [UserDashboardController::class,'get_raised_tickets']);
    Route::Post('/add_story_comment', [UserDashboardController::class,'add_story_comment']);

    //m13
    Route::post('/notification_on_off', [ApiNotificationController::class,'notification_on_off']);
  
});

    Route::get('/user/show-all-live-streaming-request', [UserDashboardController::class,'live_room_records']);

    Route::Post('/user/user-get-deals', [UserDashboardController::class,'UserHomescreenDeals']);


    // some time i got token or some time not
    // Route::middleware(['auth:api'])->group(function () {

    Route::get('/user/get_seller_stories', [UserDashboardController::class,'get_seller_stories']);
    Route::get('/user/get_seller_reels', [UserDashboardController::class,'get_seller_reels']);
    Route::get('/user/get_seller_highlights', [UserDashboardController::class,'get_seller_highlights']);
    Route::get('/user/get_admin_stories', [UserDashboardController::class,'get_admin_stories']);
    
    // });
   
  Route::Post('/scanner-Seller-details', [UserDashboardController::class,'ScannerSellerdetails']);

  Route::get('user/suggest-store', [UserDashboardController::class,'suggestStore']); // m12 Api 
  Route::get('user/best-selling-product', [UserDashboardController::class,'bestSellingProduct']); // m12 Api 
  Route::get('user/top-rating-product', [UserDashboardController::class,'TopRatingProduct']); // m12 Api 
Route::get('user/newest-product', [UserDashboardController::class,'newestProduct']); // m12 Api 

   


Route::post('user/complete-add-money-in-wallet', [UserWalletController::class,'completeAddMoneyInWallet']);

// Affilated user APi  M7 
Route::middleware(['auth:sanctum', 'ability:AffilatedUser'])->prefix('affiliate')->group(function () {
  
Route::post('/affilated-add-address', [UserAffilatedControlller::class,'affilatedAddAddress']);
Route::post('/affilated-add-Bank-details', [UserAffilatedControlller::class,'affilatedAddBankDetails']);

Route::post('/affilated-dashboard', [UserAffilatedControlller::class,'affilatedDashboard']);

Route::post('/upload-Reverify-document', [UserAffilatedControlller::class,'uploadReverifydocument']);

Route::get('/get_affiliate_profile', [UserAffilatedControlller::class,'get_affiliate_profile']);

Route::post('/update_affiliate_profile', [UserAffilatedControlller::class,'update_affiliate_profile']);
Route::post('/update_affiliate_address', [UserAffilatedControlller::class,'update_affiliate_address']);
Route::post('/update_affiliate_bank_details', [UserAffilatedControlller::class,'update_affiliate_bank_details']);
Route::post('/add_affiliate_bank_details', [UserAffilatedControlller::class,'add_affiliate_bank_details']);
Route::post('/delete_affiliate_bank_account', [UserAffilatedControlller::class,'delete_affiliate_bank_account']);
Route::post('/update_affiliate_document', [UserAffilatedControlller::class,'update_affiliate_document']);
Route::post('/update_affiliate_password', [UserAffilatedControlller::class,'update_affiliate_password']);
Route::get('/get_all_products', [UserAffiliatedProductController::class,'get_all_products']);
Route::get('/get_my_products', [UserAffiliatedProductController::class,'get_my_products']);
Route::get('/get_product_detail', [UserAffiliatedProductController::class,'get_product_detail']);
Route::post('/add_to_my_products', [UserAffiliatedProductController::class,'add_to_my_products']);
Route::post('/generate_product_link', [UserAffiliatedProductController::class,'generate_product_link']);
Route::post('/product_search', [UserAffiliatedProductController::class,'product_search']);
Route::get('/getRecentSearchData', [UserAffiliatedProductController::class,'getRecentSearchData']);
Route::get('/getRecommendedSearchData', [UserAffiliatedProductController::class,'getRecommendedSearchData']);
 Route::get('/getLatestSearchData', [UserAffiliatedProductController::class,'getRecentSearchData']);
 Route::get('/product_filter_keys', [UserAffiliatedProductController::class,'product_filter_keys']);
 Route::get('/get_my_product_detail', [UserAffiliatedProductController::class,'get_my_product_detail']);



  Route::post('/change-mobile-number', [UserAffiliatedProductController::class, 'changeMobileNumber']);
  Route::post('/verify-otp', [UserAffiliatedProductController::class, 'verifyOtp']);


  Route::post('/default_affiliate_bank_details', [UserAffilatedControlller::class,'default_affiliate_bank_details']);
  Route::post('/affiliate_remove_affilate_product', [UserAffilatedControlller::class,'affiliate_remove_affilate_product']);

  //M9
  Route::get('/affiliate_all_order', [UserAffilatedControlller::class,'affiliate_all_order']);
  Route::get('/affiliate_single_order_details', [UserAffilatedControlller::class,'affiliate_single_order_details']);
  Route::post('/affiliate_submit_withdraw_request', [UserAffilatedControlller::class,'affiliate_submit_withdraw_request']);
  Route::get('/affiliate_all_withdraw_request', [UserAffilatedControlller::class,'affiliate_all_withdraw_request']);

  //M10

  Route::get('/affiliateUserNotification', [ApiNotificationController::class,'affiliateUserNotification']);
  Route::post('/ReadAffiliateUserNotification', [ApiNotificationController::class,'ReadAffiliateUserNotification']);
  Route::get('/CountaffiliateUserNotification', [ApiNotificationController::class,'affiliateUserNotificationCount']);

  //M11

  Route::get('/get_affiliate_dashboard_data', [UserAffiliatedProductController::class,'get_affiliate_dashboard_data']);

  //M12
  Route::post('/raise_ticket', [UserAffilatedControlller::class,'raise_ticket']);
  Route::get('/get_raised_tickets', [UserAffilatedControlller::class,'get_raised_tickets']);

  //m13
  Route::post('/affiliate_notification_on_off', [ApiNotificationController::class,'affiliate_notification_on_off']);
  


});


route::post('affiliate/affiliate-login-with-otp',[UserAffilatedControlller::class,'affiliateloginwithotp']);


Route::post('affiliate/affiliated-login', [UserAffilatedControlller::class,'affiliatedLogin']);
route::post('affiliate/forgot_password',[UserAffilatedControlller::class,'affiliate_forgot_password']);
route::post('affiliate/create_password',[UserAffilatedControlller::class,'affiliate_create_password']);

Route::post('affiliate/resend_otp',[UserAffilatedControlller::class,'resend_otp']);




Route::post('/user/Home-screen-Banner-catgory-banner', [UserDashboardController::class,'HomescreenBanner']);

Route::post('/send-message-in-chats', [UserChatController::class,'SendMessageInChats']);


Route::post('/get-Invoice', [UserDashboardController::class,'get_Invoice']);


Route::get('/store_filter', [UserStoreController::class,'store_filter']);

Route::get('user/category',[ProfileController::class, 'getCategories']);
Route::get('user/sub-category',[ProfileController::class, 'getSubCategories']);

// common APi

Route::post('upload', [CommonController::class, 'upload']);
Route::post('uploadFile', [CommonController::class, 'uploadFile']);
Route::post('uploadWithResolution', [CommonController::class, 'uploadWithResolution']);
Route::get('country', [CommonController::class, 'country']);
Route::get('all_country', [CommonController::class, 'all_country']);


Route::get('category',[CommonController::class, 'getCategories']);
Route::get('sub-category',[CommonController::class, 'getSubCategories']);
Route::get('all-brand',[CommonController::class, 'get_brand']);

Route::get('all-color',[CommonController::class, 'get_color']);
Route::get('all-size',[CommonController::class, 'get_size']);
Route::get('ticket_types',[CommonController::class, 'ticket_types']);

// cms
Route::get('contact_us',[CommonController::class, 'contact_us']);
Route::get('terms_conditions',[CommonController::class, 'terms_conditions']);
Route::get('return_policy',[CommonController::class, 'return_policy']);
Route::get('about_us',[CommonController::class, 'about_us']);
Route::get('cancellation_policy',[CommonController::class, 'cancellation_policy']);
Route::get('exchange_policy',[CommonController::class, 'exchange_policy']);
Route::get('faqs',[CommonController::class, 'faqs']);
