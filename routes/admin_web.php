<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DeliveryBoyController;
use App\Http\Controllers\Admin\ReasonController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\GiftCardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AffiliateCommissionController;
use App\Http\Controllers\Admin\BannerRequestController;
use App\Http\Controllers\Admin\LiveRequestController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\DealManagementController;
use App\Http\Controllers\Admin\FullScreenBannerController;
use App\Http\Controllers\Admin\AffiliateUserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AffiliateWithdrawController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\AdminLiveStreamController;
use App\Http\Controllers\Admin\AdminLanguageController;


use App\Http\Controllers\SaveFirebaseToken;

// Save Admin firebase Token 
Route::middleware(['checkLanguage'])->group(function(){

Route::get('admin-save-token', [SaveFirebaseToken::class, 'saveAdminToken']);

Route::get('/admin-change-language/{locale}', [AdminLanguageController::class, 'AdminChangelanguage'])->name("adminLanguage");


Route::group(['prefix'=>'admin'], function(){

    Route::match(['get','post'],'/login', [AuthController::class, 'adminLogin'])->name('adminLogin');
    Route::match(['get','post'],'/change-password', [AuthController::class, 'changePassword'])->name('admin.changePassword');
    Route::match(['get','post'],'/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
    Route::match(['get','post'],'/verify-otp', [AuthController::class, 'optVerify'])->name('optVerify');
    Route::match(['get','post'],'/resend-otp', [AuthController::class, 'resendOtp'])->name('resendOtp');

    Route::middleware([AdminAuth::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [AuthController::class, 'adminLogout'])->name('adminLogout');

        //category and subcategory management
        Route::get('/category-management', [CategoryController::class, 'categoryManagement'])->name('categoryManagement');
        Route::get('/manage-subcategory/{id}', [CategoryController::class, 'manageSubCategory'])->name('manageSubCategory');
        Route::post('/updateCategoryStatus/{id}', [CategoryController::class, 'updateCategoryStatus'])->name('updateCategoryStatus');
        Route::post('/deleteSubCategory/{id}', [CategoryController::class, 'deleteSubCategory'])->name('deleteSubCategory');
        Route::post('/updateSubCategoryStatus/{id}', [CategoryController::class, 'updateSubCategoryStatus'])->name('updateSubCategoryStatus');
        Route::post('/addSubCategory', [CategoryController::class, 'addSubCategory'])->name('addSubCategory');
        Route::post('/updateSubCategory/{id}', [CategoryController::class, 'updateSubCategory'])->name('updateSubCategory');

        //brand management
        Route::get('/brand-management', [BrandController::class, 'brandManagement'])->name('brandManagement');
        Route::post('/deleteBrand/{id}', [BrandController::class, 'deleteBrand'])->name('deleteBrand');
        Route::post('/updateBrandStatus/{id}', [BrandController::class, 'updateBrandStatus'])->name('updateBrandStatus');
        Route::post('/addBrand', [BrandController::class, 'addBrand'])->name('addBrand');
        Route::post('/updateBrand/{id}', [BrandController::class, 'updateBrand'])->name('updateBrand');

        //country,city,zone management
        Route::get('/country-management', [CountryController::class, 'countryManagement'])->name('countryManagement');
        Route::get('/manage-cities/{id}', [CountryController::class, 'manageCities'])->name('manageCities');
        Route::get('/manage-zones/{id}', [CountryController::class, 'manageZones'])->name('manageZones');
        Route::post('/addServiceCity', [CountryController::class, 'addServiceCity'])->name('admin.addServiceCity');
        Route::post('/change_service_city_status/{id}', [CountryController::class, 'change_service_city_status'])->name('admin.change_service_city_status');
        Route::post('/deleteServiceCity/{id}', [CountryController::class, 'deleteServiceCity'])->name('admin.deleteServiceCity');
        Route::post('/add_zone', [CountryController::class, 'add_zone'])->name('admin.add_zone');
        Route::post('/update_zone', [CountryController::class, 'update_zone'])->name('admin.update_zone');
        Route::post('/deleteZone/{id}', [CountryController::class, 'deleteZone'])->name('admin.deleteZone');
        Route::post('/change_zone_status/{id}', [CountryController::class, 'change_zone_status'])->name('admin.change_zone_status');

        //seller management
        Route::get('/seller-management', [SellerController::class, 'sellerManagement'])->name('sellerManagement');
        Route::post('/blockUnblockSeller/{id}', [SellerController::class, 'blockUnblockSeller'])->name('admin.blockUnblockSeller');
        Route::post('/acceptSeller/{id}', [SellerController::class, 'acceptSeller'])->name('admin.acceptSeller');
        Route::post('/rejectSeller/{id}', [SellerController::class, 'rejectSeller'])->name('admin.rejectSeller');
        Route::get('/seller-info/{id}', [SellerController::class, 'sellerInfo'])->name('admin.sellerInfo');
        Route::post('/deleteReel/{id}', [SellerController::class, 'deleteReel'])->name('admin.deleteReel');
        Route::post('/deleteStory/{id}', [SellerController::class, 'deleteStory'])->name('admin.deleteStory');

        //subscription plan management
        Route::get('/plan-management', [PlanController::class, 'planManagement'])->name('planManagement');
        Route::get('/manage-plans/{id}', [PlanController::class, 'managePlans'])->name('managePlans');
        Route::post('/change_plan_status/{id}', [PlanController::class, 'change_plan_status'])->name('admin.change_plan_status');
        Route::post('/deletePlan/{id}', [PlanController::class, 'deletePlan'])->name('admin.deletePlan');
        Route::post('/add_plan', [PlanController::class, 'add_plan'])->name('admin.add_plan');
        Route::post('/update_plan', [PlanController::class, 'update_plan'])->name('admin.update_plan');
        

        //user management
        Route::get('/user-management', [UserController::class, 'userManagement'])->name('admin.userManagement');
        Route::post('/blockUnblockUser/{id}', [UserController::class, 'blockUnblockUser'])->name('admin.blockUnblockUser');
        Route::post('/addUserWalletAmount', [UserController::class, 'addUserWalletAmount'])->name('admin.addUserWalletAmount');

        //delivery boy management
        Route::get('/delivery-boy-management', [DeliveryBoyController::class, 'deliveryBoyManagement'])->name('admin.deliveryBoyManagement');
        Route::get('/deliveryboy_reg_step1', [DeliveryBoyController::class, 'deliveryboy_reg_step1'])->name('admin.deliveryboy_reg_step1');
        Route::get('/deliveryboy_reg_step2', [DeliveryBoyController::class, 'deliveryboy_reg_step2'])->name('admin.deliveryboy_reg_step2');
        Route::get('/edit_deliveryboy_step1/{id}', [DeliveryBoyController::class, 'edit_deliveryboy_step1'])->name('admin.edit_deliveryboy_step1');
        Route::get('/edit_deliveryboy_step2', [DeliveryBoyController::class, 'edit_deliveryboy_step2'])->name('admin.edit_deliveryboy_step2');
        Route::post('/change_deliveryboy_status/{id}', [DeliveryBoyController::class, 'change_deliveryboy_status'])->name('admin.change_deliveryboy_status');
        Route::post('/deleteDeliveryBoy/{id}', [DeliveryBoyController::class, 'deleteDeliveryBoy'])->name('admin.deleteDeliveryBoy');
        Route::post('/store_reg1', [DeliveryBoyController::class, 'store_reg1'])->name('admin.store_reg1');Route::post('/store_reg1', [DeliveryBoyController::class, 'store_reg1'])->name('admin.store_reg1');
        Route::get('/check-mobile', [DeliveryBoyController::class, 'checkMobile']);
        Route::get('/check-email', [DeliveryBoyController::class, 'checkEmail']);
        Route::post('/store_reg2', [DeliveryBoyController::class, 'store_reg2'])->name('admin.store_reg2');
        Route::get('/check-mobile-edit', [DeliveryBoyController::class, 'checkMobileEdit']);
        Route::get('/check-email-edit', [DeliveryBoyController::class, 'checkEmailEdit']);
        Route::post('/store_reg1_edit', [DeliveryBoyController::class, 'store_reg1_edit'])->name('admin.store_reg1_edit');
        Route::post('/store_reg2_edit', [DeliveryBoyController::class, 'store_reg2_edit'])->name('admin.store_reg2_edit');

        //reason management
        Route::get('/reason-management', [ReasonController::class, 'reasonManagement'])->name('admin.reasonManagement');
        Route::post('/blockUnblockReason/{id}', [ReasonController::class, 'blockUnblockReason'])->name('admin.blockUnblockReason');
        Route::post('/deleteReason/{id}', [ReasonController::class, 'deleteReason'])->name('admin.deleteReason');
        Route::post('/add_reason', [ReasonController::class, 'add_reason'])->name('admin.add_reason');
        Route::post('/update_reason', [ReasonController::class, 'update_reason'])->name('admin.update_reason');

        //shipping charge and tax management
        Route::get('/shipping-management', [ShippingController::class, 'shippingManagement'])->name('admin.shippingManagement');
        Route::get('/manage-shipping-charge/{id}', [ShippingController::class, 'manageShippingCharges'])->name('admin.manageShippingCharges');
        Route::post('/update_tax', [ShippingController::class, 'update_tax'])->name('admin.update_tax');
        Route::post('/deleteShippingCharge/{id}', [ShippingController::class, 'deleteShippingCharge'])->name('admin.deleteShippingCharge');
        Route::post('/updateShippingChargeStatus/{id}', [ShippingController::class, 'updateShippingChargeStatus'])->name('admin.updateShippingChargeStatus');
        Route::post('/add_shipping_fee', [ShippingController::class, 'add_shipping_fee'])->name('admin.add_shipping_fee');
        Route::post('/update_shipping_fee', [ShippingController::class, 'update_shipping_fee'])->name('admin.update_shipping_fee');
        Route::post('/update_default_shipping_fee', [ShippingController::class, 'update_default_shipping_fee'])->name('admin.update_default_shipping_fee');


        //gift card category management
        Route::get('/giftcard-management', [GiftCardController::class, 'giftCardManagement'])->name('admin.giftCardManagement');
        Route::post('/addGiftCard', [GiftCardController::class, 'addGiftCard'])->name('admin.addGiftCard');
        Route::post('/updateGiftCard/{id}', [GiftCardController::class, 'updateGiftCard'])->name('admin.updateGiftCard');
        Route::post('/deleteGiftCard/{id}', [GiftCardController::class, 'deleteGiftCard'])->name('admin.deleteGiftCard');
        Route::post('/updateGiftCardStatus/{id}', [GiftCardController::class, 'updateGiftCardStatus'])->name('admin.updateGiftCardStatus');

        //banner per day price management
        Route::get('/banner-management', [BannerController::class, 'bannerManagement'])->name('admin.bannerManagement');
        Route::post('/update_banner', [BannerController::class, 'update_banner'])->name('admin.update_banner');

        //promocode management
        Route::get('/promocode-management', [PromoCodeController::class, 'promoCodeManagement'])->name('admin.promoCodeManagement');
        Route::post('/deletePromocode/{id}', [PromoCodeController::class, 'deletePromocode'])->name('admin.deletePromocode');
        Route::post('/updatePromoCodeStatus/{id}', [PromoCodeController::class, 'updatePromoCodeStatus'])->name('admin.updatePromoCodeStatus');
        Route::post('/add_promocode', [PromoCodeController::class, 'add_promocode'])->name('admin.add_promocode');
        Route::post('/update_promocode', [PromoCodeController::class, 'update_promocode'])->name('admin.update_promocode');
        Route::get('/add-promocode', [PromoCodeController::class, 'addPromocode'])->name('admin.addPromocode');
        Route::get('/edit-promocode/{id}', [PromoCodeController::class, 'editPromocode'])->name('admin.editPromocode');

        //order management
        Route::get('/order-management', [OrderController::class, 'orderManagement'])->name('admin.orderManagement');
        Route::get('/invoice', [OrderController::class, 'invoice'])->name('admin.invoice');
        Route::get('/getDriverListToAssign', [OrderController::class, 'getDriverListToAssign'])->name('admin.getDriverListToAssign');
        Route::post('/assignDriver', [OrderController::class, 'assignDriver'])->name('admin.assignDriver');

        //affiliate commission management
        Route::get('/affiliate-commission-management', [AffiliateCommissionController::class, 'affiliateCommissionManagement'])->name('admin.affiliateCommissionManagement');
        Route::post('/update_affiliate_commission', [AffiliateCommissionController::class, 'update_affiliate_commission'])->name('admin.update_affiliate_commission');

        //banner rtequest management
        Route::get('/banner-request-management', [BannerRequestController::class, 'bannerRequestManagement'])->name('admin.bannerRequestManagement');
        Route::post('/approveBannerRequest', [BannerRequestController::class, 'approveBannerRequest'])->name('admin.approveBannerRequest');
        Route::post('/rejectBannerRequest', [BannerRequestController::class, 'rejectBannerRequest'])->name('admin.rejectBannerRequest');
        Route::post('/updateBannerReqStatus/{id}', [BannerRequestController::class, 'updateBannerReqStatus'])->name('admin.updateBannerReqStatus');

        //live rtequest management
        Route::get('/live-request-management', [LiveRequestController::class, 'liveRequestManagement'])->name('admin.liveRequestManagement');
        Route::post('/deleteTimeslot/{id}', [LiveRequestController::class, 'deleteTimeslot'])->name('admin.deleteTimeslot');
        Route::post('/blockUnblockTimeslot/{id}', [LiveRequestController::class, 'blockUnblockTimeslot'])->name('admin.blockUnblockTimeslot');
        Route::post('/addTimeslot', [LiveRequestController::class, 'addTimeslot'])->name('admin.addTimeslot');
        Route::post('/updateTimeslot/{id}', [LiveRequestController::class, 'updateTimeslot'])->name('admin.updateTimeslot');
        Route::post('/approveLiveRequest', [LiveRequestController::class, 'approveLiveRequest'])->name('admin.approveLiveRequest');
        Route::post('/rejectLiveRequest', [LiveRequestController::class, 'rejectLiveRequest'])->name('admin.rejectLiveRequest');

        //story management
        Route::get('/story-management', [StoryController::class, 'storyManagement'])->name('admin.storyManagement');
        Route::post('/deleteStory/{id}', [StoryController::class, 'deleteStory'])->name('admin.deleteStory');
        Route::post('/addStory', [StoryController::class, 'addStory'])->name('admin.addStory');

        //deal management
        Route::get('/deal-management', [DealManagementController::class, 'dealManagement'])->name('admin.dealManagement');
        Route::get('/seller-list/{id}', [DealManagementController::class, 'sellerList'])->name('admin.sellerList');
        Route::get('/product-list/{deal_id}/{seller_id}', [DealManagementController::class, 'productList'])->name('admin.productList');
        Route::get('/getSubCategories/{id}', [DealManagementController::class, 'getSubCategories'])->name('admin.getSubCategories');
        Route::post('/updateDeal/{id}', [DealManagementController::class, 'updateDeal'])->name('admin.updateDeal');
        Route::post('/submitDeal', [DealManagementController::class, 'submitDeal'])->name('admin.submitDeal');
        Route::post('/deleteDeal/{id}', [DealManagementController::class, 'deleteDeal'])->name('admin.deleteDeal');
        Route::post('/blockUnblockDeal/{id}', [DealManagementController::class, 'blockUnblockDeal'])->name('admin.blockUnblockDeal');

        //full screen banner management
        Route::get('/fullscreen-banner-management', [FullScreenBannerController::class, 'fullScreenBannerManagement'])->name('admin.fullScreenBannerManagement');
        Route::post('/deleteFullScreenBanner/{id}', [FullScreenBannerController::class, 'deleteFullScreenBanner'])->name('admin.deleteFullScreenBanner');
        Route::post('/addFullBanner', [FullScreenBannerController::class, 'addFullBanner'])->name('admin.addFullBanner');
        Route::post('/updateFullBanner/{id}', [FullScreenBannerController::class, 'updateFullBanner'])->name('admin.updateFullBanner');
        Route::post('/deletePromotionalBanner/{id}', [FullScreenBannerController::class, 'deletePromotionalBanner'])->name('admin.deletePromotionalBanner');
        Route::post('/addPromotionalBanner', [FullScreenBannerController::class, 'addPromotionalBanner'])->name('admin.addPromotionalBanner');
        Route::get('/getCategories', [FullScreenBannerController::class, 'getCategories'])->name('admin.getCategories');
        Route::get('/getSubCategories/{id}', [FullScreenBannerController::class, 'getSubCategories'])->name('admin.getSubCategories');
        Route::post('/updatePromotionalBanner/{id}', [FullScreenBannerController::class, 'updatePromotionalBanner'])->name('admin.updatePromotionalBanner');
        Route::post('/blockUnblockPromotionalBanner/{id}', [FullScreenBannerController::class, 'blockUnblockPromotionalBanner'])->name('admin.blockUnblockPromotionalBanner');

        //affiliate user management
        Route::get('/affiliate-user-management', [AffiliateUserController::class, 'affiliateUserManagement'])->name('admin.affiliateUserManagement');
        Route::post('/blockUnblockAffiliateUser/{id}', [AffiliateUserController::class, 'blockUnblockAffiliateUser'])->name('admin.blockUnblockAffiliateUser');
        Route::post('/acceptAffiliateUser/{id}', [AffiliateUserController::class, 'acceptAffiliateUser'])->name('admin.acceptAffiliateUser');
        Route::post('/rejectAffiliateUser/{id}', [AffiliateUserController::class, 'rejectAffiliateUser'])->name('admin.rejectAffiliateUser');

        //affiliate user management
        Route::get('/product-management', [ProductController::class, 'productManagement'])->name('admin.productManagement');

        //affiliate user withdraw request management
        Route::get('/affiliate-withdraw-request-management', [AffiliateWithdrawController::class, 'affiliateWithdrawRequestManagement'])->name('admin.affiliateWithdrawRequestManagement');
        Route::post('/rejectWithdrawRequest/{id}', [AffiliateWithdrawController::class, 'rejectWithdrawRequest'])->name('admin.rejectWithdrawRequest');
        Route::post('/approveWithdrawRequest', [AffiliateWithdrawController::class, 'approveWithdrawRequest'])->name('admin.approveWithdrawRequest');
        Route::post('/transferWithdrawRequest', [AffiliateWithdrawController::class, 'transferWithdrawRequest'])->name('admin.transferWithdrawRequest');
        Route::get('/myfatoorah/success', [AffiliateWithdrawController::class, 'paymentSuccess'])->name('admin.payment.success');
        Route::get('/myfatoorah/error', [AffiliateWithdrawController::class, 'paymentError'])->name('admin.payment.error');

        //cms management
        Route::get('/cms-management', [CmsController::class, 'cmsManagement'])->name('admin.cmsManagement');
        Route::post('/create_update_terms_condition', [CmsController::class, 'create_update_terms_condition'])->name('admin.create_update_terms_condition');
        Route::post('/create_update_return_policy', [CmsController::class, 'create_update_return_policy'])->name('admin.create_update_return_policy');
        Route::post('/create_update_about_us', [CmsController::class, 'create_update_about_us'])->name('admin.create_update_about_us');
        Route::post('/create_update_cancellation_policy', [CmsController::class, 'create_update_cancellation_policy'])->name('admin.create_update_cancellation_policy');
        Route::post('/create_update_exchange_policy', [CmsController::class, 'create_update_exchange_policy'])->name('admin.create_update_exchange_policy');
        Route::post('/add_faq', [CmsController::class, 'add_faq'])->name('admin.add_faq');
        Route::post('/update_faq', [CmsController::class, 'update_faq'])->name('admin.update_faq');
        Route::post('/delete_faq', [CmsController::class, 'delete_faq'])->name('admin.delete_faq');
        Route::post('/create_update_contact_us', [CmsController::class, 'create_update_contact_us'])->name('admin.create_update_contact_us');

        //notification management
        Route::get('/notification-management', [NotificationController::class, 'notificationManagement'])->name('admin.notificationManagement');
        Route::get('/send-notification', [NotificationController::class, 'sendNotification'])->name('admin.sendNotification');
        Route::post('/send_notification', [NotificationController::class, 'send_notification'])->name('admin.send_notification');

        //ticket management
        Route::get('/ticket-management', [TicketController::class, 'ticketManagement'])->name('admin.ticketManagement');
        Route::post('/update_ticket_status', [TicketController::class, 'update_ticket_status'])->name('admin.update_ticket_status');
        Route::get('/payment-management', [PaymentController::class, 'paymentManagement'])->name('admin.paymentManagement');
            
        
        // seller Live Stream 
        
     Route::get('/seller-live-stream-Managemnt', [AdminLiveStreamController::class, 'sellerlivestreamManagemnt'])->name('admin.sellerlivestreamManagemnt');

     //m13
     Route::get('/account-setting', [AuthController::class, 'accountSetting'])->name('admin.accountSetting');
     Route::post('/update_account', [AuthController::class, 'update_account'])->name('admin.update_account');
     Route::post('/update_password', [AuthController::class, 'update_password'])->name('admin.update_password');
     Route::get('/sub-admin-managemnet', [AuthController::class, 'subAdminManagement'])->name('admin.subAdminManagement');
     Route::get('/add-subadmin', [AuthController::class, 'add_subadmin'])->name('admin.add_subadmin');
     Route::post('/addSubadmin', [AuthController::class, 'addSubadmin'])->name('admin.addSubadmin');
     Route::post('/updateSubadmin', [AuthController::class, 'updateSubadmin'])->name('admin.updateSubadmin');
     Route::post('/sendCredentials', [AuthController::class, 'sendCredentials'])->name('admin.sendCredentials');
     Route::get('/edit-subadmin/{id}', [AuthController::class, 'edit_subadmin'])->name('admin.edit_subadmin');
     Route::post('/deleteSubAdmin/{id}', [AuthController::class, 'deleteSubAdmin'])->name('admin.deleteSubAdmin');
     Route::post('/updateSubAdminStatus/{id}', [AuthController::class, 'updateSubAdminStatus'])->name('admin.updateSubAdminStatus');
     Route::get('/refund-managemnet', [AuthController::class, 'refundManagement'])->name('admin.refundManagement');

     //m14
     //dashboard export
     Route::get('/export_dashboard_data', [DashboardController::class, 'export_dashboard_data'])->name('admin.export_dashboard_data');
     //user export
     Route::get('/export_user_data', [UserController::class, 'export_user_data'])->name('admin.export_user_data');
     //seller export
     Route::get('/export_new_seller_data', [SellerController::class, 'export_new_seller_data'])->name('admin.export_new_seller_data');
     Route::get('/export_approved_seller_data', [SellerController::class, 'export_approved_seller_data'])->name('admin.export_approved_seller_data');
     Route::get('/export_rejected_seller_data', [SellerController::class, 'export_rejected_seller_data'])->name('admin.export_rejected_seller_data');
     //affiliate export
     Route::get('/export_new_affiliate_data', [AffiliateUserController::class, 'export_new_affiliate_data'])->name('admin.export_new_affiliate_data');
     Route::get('/export_approved_affiliate_data', [AffiliateUserController::class, 'export_approved_affiliate_data'])->name('admin.export_approved_affiliate_data');
     Route::get('/export_rejected_affiliate_data', [AffiliateUserController::class, 'export_rejected_affiliate_data'])->name('admin.export_rejected_affiliate_data');
     //driver export
     Route::get('/export_driver_data', [DeliveryBoyController::class, 'export_driver_data'])->name('admin.export_driver_data');
     //order export
     Route::get('/export_active_orders_data', [OrderController::class, 'export_active_orders_data'])->name('admin.export_active_orders_data');
     Route::get('/export_return_exchange_orders_data', [OrderController::class, 'export_return_exchange_orders_data'])->name('admin.export_return_exchange_orders_data');
     Route::get('/export_completed_orders_data', [OrderController::class, 'export_completed_orders_data'])->name('admin.export_completed_orders_data');
     Route::get('/export_cancelled_orders_data', [OrderController::class, 'export_cancelled_orders_data'])->name('admin.export_cancelled_orders_data');
     //product export
     Route::get('/export_products_data', [ProductController::class, 'export_products_data'])->name('admin.export_products_data');    
     //ticket export
     Route::get('/export_new_tickets_data', [TicketController::class, 'export_new_tickets_data'])->name('admin.export_new_tickets_data'); 
     Route::get('/export_ongoing_tickets_data', [TicketController::class, 'export_ongoing_tickets_data'])->name('admin.export_ongoing_tickets_data'); 
     Route::get('/export_past_tickets_data', [TicketController::class, 'export_past_tickets_data'])->name('admin.export_past_tickets_data'); 
     //payment export
     Route::get('/export_order_payment_data', [PaymentController::class, 'export_order_payment_data'])->name('admin.export_order_payment_data');
     Route::get('/export_plan_payment_data', [PaymentController::class, 'export_plan_payment_data'])->name('admin.export_plan_payment_data');
     Route::get('/export_giftcard_payment_data', [PaymentController::class, 'export_giftcard_payment_data'])->name('admin.export_giftcard_payment_data');
     Route::get('/export_banner_payment_data', [PaymentController::class, 'export_banner_payment_data'])->name('admin.export_banner_payment_data');
     //refund export
     Route::get('/export_refund_data_new', [AuthController::class, 'export_refund_data_new'])->name('admin.export_refund_data_new');

        

     
        




    });

});

});






Route::fallback(function (Request $request) {
    $uri = $request->getRequestUri();

    if (str_starts_with($uri, '/Admin') || preg_match('/\/[A-Z]/', $uri)) {
        return redirect(strtolower($uri), 301);
    }

    abort(404);
});