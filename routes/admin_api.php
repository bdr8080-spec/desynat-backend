<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\BrandController;
use App\Http\Controllers\Api\Admin\SellerController;
use App\Http\Controllers\Api\Admin\CountryController;
use App\Http\Controllers\Api\Admin\PlanController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ReasonController;
use App\Http\Controllers\Api\Admin\DeliveryBoyController;
use App\Http\Controllers\Api\Admin\ShippingTaxController;
use App\Http\Controllers\Api\Admin\GiftCardController;
use App\Http\Controllers\Api\Admin\BannerController;
use App\Http\Controllers\Api\Admin\PromocodeController;
use App\Http\Controllers\Api\Admin\AffiliateCommissionController;
use App\Http\Controllers\Api\Admin\OrderManagementController;
use App\Http\Controllers\Api\Admin\DealController;
use App\Http\Controllers\Api\Admin\StoryController;
use App\Http\Controllers\Api\Admin\LiveRequestController;
use App\Http\Controllers\Api\Admin\FullBannerController;
use App\Http\Controllers\Api\Admin\AffiliatedUserController;
use App\Http\Controllers\Api\Admin\ProductManagementController;
use App\Http\Controllers\Api\Admin\WithdrawRequestController;
use App\Http\Controllers\Api\Admin\CMSController;
use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Admin\TicketController;
use App\Http\Controllers\Api\Admin\PaymentController;


// Admin APi M1
Route::group(['prefix' => 'admin'], function () {   
    Route::post('/admin_login',[AuthController::class,'admin_login']);
    Route::post('/admin_forgot_password',[AuthController::class,'admin_forgot_password']);
    Route::post('/admin_verify_otp',[AuthController::class,'admin_verify_otp']);
    Route::post('/admin_create_password',[AuthController::class,'admin_create_password']);
    Route::post('/resend_otp',[AuthController::class,'resend_otp']);
    
    Route::get('/get_countries',[CountryController::class,'get_countries']);


   Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {

      //Logout
      Route::post('/admin_logout',[AuthController::class,'admin_logout']);

      //Category and sub category
      Route::get('/get_category',[CategoryController::class,'get_category']);
      Route::get('/get_subcategories',[CategoryController::class,'get_subcategories']);
      Route::post('/change_category_status',[CategoryController::class,'change_category_status']);
      Route::post('/change_subcategory_status',[CategoryController::class,'change_subcategory_status']);
      Route::post('/add_subcategory',[CategoryController::class,'add_subcategory']);
      Route::post('/update_subcategory',[CategoryController::class,'update_subcategory']);
      Route::post('/delete_subcategory',[CategoryController::class,'delete_subcategory']);

      //Brand
      Route::get('/get_brand',[BrandController::class,'get_brand']);
      Route::post('/change_brand_status',[BrandController::class,'change_brand_status']);
      Route::post('/add_brand',[BrandController::class,'add_brand']);
      Route::post('/update_brand',[BrandController::class,'update_brand']);
      Route::post('/delete_brand',[BrandController::class,'delete_brand']);
      //M1 api ends

     //M2 Api Starts

     //Seller management
     Route::get('/get_new_sellers',[SellerController::class,'get_new_sellers']);
     Route::get('/get_approved_sellers',[SellerController::class,'get_approved_sellers']);
     Route::get('/get_rejected_sellers',[SellerController::class,'get_rejected_sellers']);
     Route::get('/get_seller_details',[SellerController::class,'get_seller_details']);
     Route::post('/accept_seller',[SellerController::class,'accept_seller']);
     Route::post('/reject_seller',[SellerController::class,'reject_seller']);
     Route::post('/block_unblock_seller',[SellerController::class,'block_unblock_seller']);

     //country,city,zone management
     Route::get('/get_cities',[CountryController::class,'get_cities']);
     Route::get('/get_service_cities',[CountryController::class,'get_service_cities']);
     Route::post('/add_service_city',[CountryController::class,'add_service_city']);
     Route::post('/change_service_city_status',[CountryController::class,'change_service_city_status']);
     Route::post('/delete_service_city',[CountryController::class,'delete_service_city']);
     Route::get('/get_zones',[CountryController::class,'get_zones']);
     Route::get('/get_zone_details',[CountryController::class,'get_zone_details']);
     Route::post('/add_zone',[CountryController::class,'add_zone']);
     Route::post('/update_zone',[CountryController::class,'update_zone']);
     Route::post('/change_zone_status',[CountryController::class,'change_zone_status']);
     Route::post('/delete_zone',[CountryController::class,'delete_zone']);

     //Plan Management
     Route::post('/add_plan',[PlanController::class,'add_plan']);
     Route::post('/update_plan',[PlanController::class,'update_plan']);
     Route::get('/get_plans',[PlanController::class,'get_plans']);
     Route::get('/get_plan_details',[PlanController::class,'get_plan_details']);
     Route::post('/change_plan_status',[PlanController::class,'change_plan_status']);
     Route::post('/delete_plan',[PlanController::class,'delete_plan']);
     
     //M2 api ends

     //M3 api starts

     //user management
     Route::get('/get_users',[UserController::class,'getUsers']);
     Route::get('/get_user_countries_list',[UserController::class,'get_user_countries_list']);
     Route::get('/get_user_details',[UserController::class,'get_user_details']);
     Route::post('/block_unblock_user',[UserController::class,'block_unblock_user']);
     Route::post('/add_user_wallet_amount',[UserController::class,'add_user_wallet_amount']);

     //reason management
     Route::get('/get_reasons',[ReasonController::class,'get_reasons']);
     Route::post('/change_reason_status',[ReasonController::class,'change_reason_status']);
     Route::post('/add_reason',[ReasonController::class,'add_reason']);
     Route::post('/update_reason',[ReasonController::class,'update_reason']);
     Route::post('/delete_reason',[ReasonController::class,'delete_reason']);

     //delivery boy management
     Route::get('/get_delivery_boys',[DeliveryBoyController::class,'getDeliveryBoys']);
     Route::get('/get_deliveryboy_details',[DeliveryBoyController::class,'get_deliveryboy_details']);
     Route::post('/block_unblock_deliveryboy',[DeliveryBoyController::class,'block_unblock_deliveryboy']);
     Route::post('/delete_deliveryboy',[DeliveryBoyController::class,'delete_deliveryboy']);
     Route::post('/add_deliveryBoy',[DeliveryBoyController::class,'add_deliveryBoy']);
     Route::post('/update_deliveryBoy',[DeliveryBoyController::class,'update_deliveryBoy']);
     Route::get('/get_kuwait_zones',[DeliveryBoyController::class,'get_kuwait_zones']);

     //M3 api ends

     //M4 api starts

     //tax and shipping management
     Route::post('/add_tax',[ShippingTaxController::class,'add_tax']);
     Route::get('/countries_with_tax_shipping',[ShippingTaxController::class,'countries_with_tax_shipping']);
     Route::get('/shipping_charges_by_countryId',[ShippingTaxController::class,'shipping_charges_by_countryId']);
     Route::post('/add_shipping_charge',[ShippingTaxController::class,'add_shipping_charge']);
     Route::post('/update_shipping_charge',[ShippingTaxController::class,'update_shipping_charge']);
     Route::post('/blobk_unblock_shippingFee',[ShippingTaxController::class,'blobk_unblock_shippingFee']);
     Route::post('/delete_shipping_fee',[ShippingTaxController::class,'delete_shipping_fee']);

     //gift card management
     Route::post('/add_giftCard',[GiftCardController::class,'add_giftCard']);
     Route::post('/update_giftCard',[GiftCardController::class,'update_giftCard']);
     Route::post('/delete_gift_card',[GiftCardController::class,'delete_gift_card']);
     Route::post('/block_unblock_giftCard',[GiftCardController::class,'block_unblock_giftCard']);
     Route::get('/get_giftCards',[GiftCardController::class,'get_giftCards']);

     //banner per day price management
     Route::post('/add_update_banner',[BannerController::class,'add_update_banner']);
     Route::get('/get_banners',[BannerController::class,'get_banners']);

     //promocode management
     Route::post('/add_promocode',[PromocodeController::class,'add_promocode']);
     Route::post('/update_promocode',[PromocodeController::class,'update_promocode']);
     Route::post('/delete_promocode',[PromocodeController::class,'delete_promocode']);
     Route::post('/block_unblock_promocode',[PromocodeController::class,'block_unblock_promocode']);
     Route::get('/get_promocodes',[PromocodeController::class,'get_promocodes']);

     //M4 api ends

     //M5 api starts

     //affiliate commission management
     Route::post('/update_affiliate_commission',[AffiliateCommissionController::class,'update_affiliate_commission']);
     Route::get('/countries_with_affiliate_commission',[AffiliateCommissionController::class,'countries_with_affiliate_commission']);

     //order management
     Route::get('/active_orders',[OrderManagementController::class,'active_orders']);
     Route::get('/return_orders',[OrderManagementController::class,'return_orders']);
     Route::get('/completed_orders',[OrderManagementController::class,'completed_orders']);
     Route::get('/cancelled_orders',[OrderManagementController::class,'cancelled_orders']);
     Route::get('/single_order_detail',[OrderManagementController::class,'single_order_detail']);

     Route::get('/get_drivers_to_assign',[OrderManagementController::class,'get_drivers_to_assign']);
     Route::post('/assign_driver',[OrderManagementController::class,'assign_driver']);

     //Banner request management
     Route::get('/get_banner_request',[BannerController::class,'get_banner_request']);
     Route::post('/approve_banner_request',[BannerController::class,'approve_banner_request']);
     Route::post('/reject_banner_request',[BannerController::class,'reject_banner_request']);
     Route::post('/block_unblock_banner_req',[BannerController::class,'block_unblock_banner_req']);

     //M5 api ends

     //M6 api starts

     //Deal Management
     Route::post('/add_deal',[DealController::class,'add_deal']);
     Route::post('/update_deal',[DealController::class,'update_deal']);
     Route::get('/get_active_deals',[DealController::class,'get_active_deals']);
     Route::get('/get_expired_deals',[DealController::class,'get_expired_deals']);
     Route::post('/block_unblock_deal',[DealController::class,'block_unblock_deal']);
     Route::post('/delete_deal',[DealController::class,'delete_deal']);
     Route::get('/get_deal_detail',[DealController::class,'get_deal_detail']);
     Route::get('/get_deal_seller_product_list',[DealController::class,'get_deal_seller_product_list']);

     //story Management
     Route::post('/add_story',[StoryController::class,'add_story']);
     Route::get('/get_seller_stories',[StoryController::class,'get_seller_stories']);
     Route::get('/get_admin_stories',[StoryController::class,'get_admin_stories']);
     Route::post('/delete_story',[StoryController::class,'delete_story']);

     //live request & timeslot Management
     Route::post('/add_timeslot',[LiveRequestController::class,'add_timeslot']);
     Route::post('/update_timeslot',[LiveRequestController::class,'update_timeslot']);
     Route::post('/delete_timeslot',[LiveRequestController::class,'delete_timeslot']);
     Route::post('/block_unblock_timeslot',[LiveRequestController::class,'block_unblock_timeslot']);
     Route::get('/get_timeslots',[LiveRequestController::class,'get_timeslots']);
     Route::get('/get_live_requests',[LiveRequestController::class,'get_live_requests']);
     Route::post('/accept_live_request',[LiveRequestController::class,'accept_live_request']);
     Route::post('/reject_live_request',[LiveRequestController::class,'reject_live_request']);

     //FUll banner management
     Route::post('/add_full_banner',[FullBannerController::class,'add_full_banner']);
     Route::post('/update_full_banner',[FullBannerController::class,'update_full_banner']);
     Route::post('/delete_full_banner',[FullBannerController::class,'delete_full_banner']);
     Route::get('/get_full_banners',[FullBannerController::class,'get_full_banners']);
     Route::get('/get_banner_detail',[FullBannerController::class,'get_banner_detail']);
     Route::post('/add_promotional_banner',[FullBannerController::class,'add_promotional_banner']);
     Route::post('/update_promotional_banner',[FullBannerController::class,'update_promotional_banner']);
     Route::post('/delete_promotional_banner',[FullBannerController::class,'delete_promotional_banner']);
     Route::get('/get_promotional_banners',[FullBannerController::class,'get_promotional_banners']);
     Route::get('/get_promotional_banner_detail',[FullBannerController::class,'get_promotional_banner_detail']);
     Route::post('/block_unblock_promotional_banner',[FullBannerController::class,'block_unblock_promotional_banner']);

     //affiliated user management
     Route::get('/get_new_affilaited_users',[AffiliatedUserController::class,'get_new_affilaited_users']);
     Route::get('/get_approved_affilaited_users',[AffiliatedUserController::class,'get_approved_affilaited_users']);
     Route::get('/get_rejected_affilaited_users',[AffiliatedUserController::class,'get_rejected_affilaited_users']);
     Route::get('/get_affiliate_user_details',[AffiliatedUserController::class,'get_affiliate_user_details']);
     Route::post('/accept_affiliate_user',[AffiliatedUserController::class,'accept_affiliate_user']);
     Route::post('/reject_affiliate_user',[AffiliatedUserController::class,'reject_affiliate_user']);
     Route::post('/block_unblock_affiliate_user',[AffiliatedUserController::class,'block_unblock_affiliate_user']);

     //M8 api starts
     Route::get('/get_products',[ProductManagementController::class,'get_products']);
     Route::get('/get_product_detail',[ProductManagementController::class,'get_product_detail']);
     Route::post('/block_unblock_product',[ProductManagementController::class,'block_unblock_product']);
     Route::get('/get_default_shipping_fee',[ShippingTaxController::class,'get_default_shipping_fee']);
     Route::post('/update_default_shipping_fee',[ShippingTaxController::class,'update_default_shipping_fee']);

     //M9 api starts
     Route::get('/get_withdraw_requests',[WithdrawRequestController::class,'get_withdraw_requests']);
     Route::post('/reject_withdraw_request',[WithdrawRequestController::class,'reject_withdraw_request']);
     Route::post('/approve_withdraw_request',[WithdrawRequestController::class,'approve_withdraw_request']);
     Route::post('/transfer_withdraw_request',[WithdrawRequestController::class,'transfer_withdraw_request']);

     //M10 api starts
     Route::post('/create_update_terms_condition',[CMSController::class,'create_update_terms_condition']);
     Route::get('/get_terms_condition',[CMSController::class,'get_terms_condition']);
     Route::post('/create_update_return_policy',[CMSController::class,'create_update_return_policy']);
     Route::get('/get_return_policy',[CMSController::class,'get_return_policy']);
     Route::post('/create_update_about_us',[CMSController::class,'create_update_about_us']);
     Route::get('/get_about_us',[CMSController::class,'get_about_us']);
     Route::post('/create_update_cancellation_policy',[CMSController::class,'create_update_cancellation_policy']);
     Route::get('/get_cancellation_policy',[CMSController::class,'get_cancellation_policy']);
     Route::post('/create_update_exchange_policy',[CMSController::class,'create_update_exchange_policy']);
     Route::get('/get_exchange_policy',[CMSController::class,'get_exchange_policy']);
     Route::post('/create_update_contact_us',[CMSController::class,'create_update_contact_us']);
     Route::get('/get_contact_us',[CMSController::class,'get_contact_us']);
     Route::post('/add_faq',[CMSController::class,'add_faq']);
     Route::post('/update_faq',[CMSController::class,'update_faq']);
     Route::get('/get_faq',[CMSController::class,'get_faq']);
     Route::post('/delete_faq',[CMSController::class,'delete_faq']);

     Route::post('/send_notification',[NotificationController::class,'send_notification']);
     Route::get('/get_send_notifications_list',[NotificationController::class,'get_send_notifications_list']);
     Route::get('/get_my_notifications_list',[NotificationController::class,'get_my_notifications_list']);
     Route::post('/mark_notification_as_read',[NotificationController::class,'mark_notification_as_read']);
     Route::post('/mark_all_notification_as_read',[NotificationController::class,'mark_all_notification_as_read']);
     Route::get('/get_admin_notifications_count',[NotificationController::class,'get_admin_notifications_count']);
     

    Route::get('/admin-all-live-request',[LiveRequestController::class,'adminAllLiveRequest']);

    //m12

    Route::get('/get_new_tickets', [TicketController::class,'get_new_tickets']);
    Route::get('/get_ongoing_tickets', [TicketController::class,'get_ongoing_tickets']);
    Route::get('/get_resolved_tickets', [TicketController::class,'get_resolved_tickets']);
    Route::post('/update_ticket_status', [TicketController::class,'update_ticket_status']);

    Route::get('/get_order_payments', [PaymentController::class,'get_order_payments']);







   });


});