<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\User\AuthController;

use App\Http\Controllers\Api\User\UserDashboardController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\AddressController;
use App\Http\Controllers\Api\User\UserStoreController;
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
  Route::delete('/delete-address', [AddressController::class, 'deleteAddress']);


  // M3 Api User

  Route::post('/category-Wise-Store-List', [UserStoreController::class,'category_Wise_Store_List']);
  Route::post('/single-store-details', [UserStoreController::class,'single_store_details']);
  
  Route::post('/product-add-to-wishlist', [UserStoreController::class,'product_add_to_wishlist']);

  Route::post('/product-add-to-cart', [UserStoreController::class,'product_add_to_cart']);

  Route::get('/view_cart_details', [UserStoreController::class,'view_cart_details']);

  Route::post('/addtocart-increment-decrement', [UserStoreController::class,'addtocart_increment_decrement']);


});


Route::get('/store_filter', [UserStoreController::class,'store_filter']);

Route::get('user/category',[ProfileController::class, 'getCategories']);
Route::get('user/sub-category',[ProfileController::class, 'getSubCategories']);

// common APi

Route::post('upload', [CommonController::class, 'upload']);
Route::get('country', [CommonController::class, 'country']);
Route::get('all_country', [CommonController::class, 'all_country']);