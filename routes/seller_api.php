<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Seller\AuthController;

use App\Http\Controllers\Api\Seller\SellerDashboardController;

use App\Http\Controllers\Api\Seller\SellerProductController;
use App\Http\Controllers\Api\Seller\SellerBannerController;
use App\Http\Controllers\Api\Seller\OrderManagement;

use App\Http\Controllers\Api\Seller\SellerDealManagement;
use App\Http\Controllers\Api\Seller\SellerLiveRequestController;
use App\Http\Controllers\Api\Seller\NotificationController;

use App\Http\Controllers\CommonController;


// M1 Milestone 
Route::group(['prefix' => 'seller'], function () {
    Route::post('create_account', [AuthController::class, 'create_account']);
    Route::post('/verify_otp',[AuthController::class,'verify_otp']);
    Route::post('/resend_otp',[AuthController::class,'resend_otp']);


Route::post('/store_information', [AuthController::class,'store_information']);
Route::post('/store_document_and_bank_details', [AuthController::class,'store_document_and_bank_details']);

Route::post('/seller_review', [AuthController::class,'seller_review']);

Route::post('/seller_store_submit_request', [AuthController::class,'seller_store_submit_request']);

Route::post('/login',[AuthController::class,'login']);

route::post('/forgot_password',[AuthController::class,'forgot_password']);
route::post('/create_password',[AuthController::class,'create_password']);

// Auth Checking
Route::middleware(['auth:sanctum', 'ability:seller'])->group(function () {

  Route::post('/seller-dashboard', [SellerDashboardController::class,'index']);

  Route::get('/logout', [SellerDashboardController::class,'logout']);

  Route::get('/all-plans', [SellerDashboardController::class,'all_plans']);

  Route::get('/single-plans-show/{id}', [SellerDashboardController::class,'single_plans_show']);


  Route::post('/create-subcription-plan-buy', [SellerDashboardController::class,'create_subcription_plan_buy']);

  Route::post('/payment-subcription-plan', [SellerDashboardController::class,'payment_subcription_plan']);

  Route::post('/seller-profile', [SellerDashboardController::class,'seller_profile']);

  // M3 Api 

    Route::get('/store_on_off', [SellerDashboardController::class,'store_on_off']);

    
    Route::post('add-product',[SellerProductController::class, 'add_product']);

    Route::post('edit-product',[SellerProductController::class, 'edit_product']);

    Route::post('add-product1',[SellerProductController::class, 'add_product1']);
    Route::post('edit-product1',[SellerProductController::class, 'edit_product1']);

    Route::post('all-product',[SellerProductController::class, 'all_product']);

    Route::post('single-product-details',[SellerProductController::class, 'seller_single_product_details']);

    Route::put('product-status-active-inactive',[SellerProductController::class, 'product_status_active_inactive']);

    Route::delete('product-delete',[SellerProductController::class, 'product_delete']);


    // M4 Apis

    Route::post('all-Inventory-product',[SellerProductController::class, 'all_Inventory_product']);

    Route::put('update-stock-inventory',[SellerProductController::class, 'update_stock_inventory']);

    Route::put('update-affilate-commission',[SellerProductController::class, 'update_affilate_commission']);

    Route::get('view-profile',[SellerProductController::class, 'view_profile']);
    
    Route::post('/update-store-information', [SellerProductController::class,'update_store_information']);
    Route::post('/update-store-bank-details', [SellerProductController::class,'update_store_bank_details']);


    // M5 Apis

    Route::post('/get-seller-banner-price', [SellerBannerController::class,'seller_banner_price']);
    Route::post('/add-banner', [SellerBannerController::class,'Add_Banner']);
    Route::post('/complete-banner-payment', [SellerBannerController::class,'complete_banner_payment']);
    Route::post('/all-banners', [SellerBannerController::class,'all_banners']);

    // M6 APis

  Route::post('/all-orders', [OrderManagement::class,'all_orders']);
  Route::post('/single-orders-data', [OrderManagement::class,'single_orders_data']);

  Route::post('/update-single-order-status', [OrderManagement::class,'updateSingleOrderStatus']);

  route::Match(['get','post'],'/update-order-exchange-return-status',[OrderManagement::class,'updateOrderExchangeReturnStatus']);

  Route::post('/all-chats-records', [OrderManagement::class,'AllChatsAndOrders']);

  Route::post('/single-chats-records', [OrderManagement::class,'singleChatsRecords']);

  Route::post('/Modify-single-chats-records', [OrderManagement::class,'Modifysinglechatsrecords']);

  // M7 APi 

    Route::post('/view-deals', [SellerDealManagement::class,'view_deals']);
    
    Route::post('/view-single-deals', [SellerDealManagement::class,'viewsingledeals']);

    Route::post('/show-allproduct-deal-catgeory-subCatgory', [SellerDealManagement::class,'showAllproductOnDealTime']);

    Route::post('/Add-products-in-deal-inside', [SellerDealManagement::class,'AddProductSinDeals']);

    Route::post('/remove-products-in-deal', [SellerDealManagement::class,'removeProductsInDeal']);

    //M8
    Route::get('/get_timeslots', [SellerLiveRequestController::class,'get_timeslots']);
    Route::get('/get_live_requests', [SellerLiveRequestController::class,'get_live_requests']);
    Route::post('/cancel_live_request', [SellerLiveRequestController::class,'cancel_live_request']);
    Route::post('/send_live_request', [SellerLiveRequestController::class,'send_live_request']);

    //M10
    Route::get('/get_my_notifications_list', [NotificationController::class,'get_my_notifications_list']);
    Route::post('/mark_notification_as_read', [NotificationController::class,'mark_notification_as_read']);
    Route::post('/mark_all_notification_as_read', [NotificationController::class,'mark_all_notification_as_read']);
    Route::post('/renew_subcription_plan_buy', [SellerDashboardController::class,'renew_subcription_plan_buy']);
    Route::get('/my_plans', [SellerDashboardController::class,'my_plans']);
    Route::get('/get_seller_notifications_count', [NotificationController::class,'get_seller_notifications_count']);

    //M11
    Route::post('/add_story', [SellerDashboardController::class,'add_story']);
    Route::post('/delete_story', [SellerDashboardController::class,'delete_story']);
    Route::post('/add_highlights', [SellerDashboardController::class,'add_highlights']);
    Route::post('/delete_highlight', [SellerDashboardController::class,'delete_highlight']);
    Route::post('/add_reels', [SellerDashboardController::class,'add_reels']);
    Route::post('/delete_reel', [SellerDashboardController::class,'delete_reel']);
    Route::post('/update_reel', [SellerDashboardController::class,'update_reel']);
    Route::post('/update_reel_status', [SellerDashboardController::class,'update_reel_status']);
    Route::get('/get_my_stories', [SellerDashboardController::class,'get_my_stories']);
    Route::get('/get_my_reels', [SellerDashboardController::class,'get_my_reels']);
    Route::get('/get_my_highlights', [SellerDashboardController::class,'get_my_highlights']);
    Route::post('/upload_story_from_gallery', [SellerDashboardController::class,'upload_story_from_gallery']);
    Route::post('/upload_highlight_from_gallery', [SellerDashboardController::class,'upload_highlight_from_gallery']);


    // m11 Apis

  Route::get('/live_room_records', [SellerLiveRequestController::class,'live_room_records']);

   Route::get('/get_Seller_admin_stories', [SellerDashboardController::class,'SellerSide_get_admin_stories']);
   


});


Route::get('category',[CommonController::class, 'getCategories']);
Route::get('sub-category',[CommonController::class, 'getSubCategories']);
Route::get('all-brand',[CommonController::class, 'get_brand']);

Route::get('all-color',[CommonController::class, 'get_color']);
Route::get('all-size',[CommonController::class, 'get_size']);






});


Route::get('/upload_color', [SellerDashboardController::class,'upload_color']);

Route::get('/all_color', [SellerDashboardController::class,'upload_color']);