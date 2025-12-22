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

        //promocode management
        Route::get('/order-management', [OrderController::class, 'orderManagement'])->name('admin.orderManagement');

        //promocode management
        Route::get('/affiliate-commission-management', [AffiliateCommissionController::class, 'affiliateCommissionManagement'])->name('admin.affiliateCommissionManagement');

        //promocode management
        Route::get('/banner-request-management', [BannerRequestController::class, 'bannerRequestManagement'])->name('admin.bannerRequestManagement');
        

    });

});




Route::fallback(function (Request $request) {
    $uri = $request->getRequestUri();

    if (str_starts_with($uri, '/Admin') || preg_match('/\/[A-Z]/', $uri)) {
        return redirect(strtolower($uri), 301);
    }

    abort(404);
});