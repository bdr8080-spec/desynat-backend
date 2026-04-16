<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DeliveryBoy\AuthController;

use App\Http\Controllers\Api\DeliveryBoy\DeliveryBoyDashboardController;
use App\Http\Controllers\Api\DeliveryBoy\DeliveryBoyProfileController;
use App\Http\Controllers\Api\DeliveryBoy\DeliveryBoyOrderController;
use App\Http\Controllers\Api\DeliveryBoy\NotificationController;


// M1 Milestone 
Route::group(['prefix' => 'deliveryboy'], function () {
    Route::post('/verify_otp',[AuthController::class,'verify_otp']);
    Route::post('/resend_otp',[AuthController::class,'resend_otp']);
    Route::post('/login',[AuthController::class,'login']);
    route::post('/forgot_password',[AuthController::class,'forgot_password']);
    route::post('/create_password',[AuthController::class,'create_password']);

    // Auth Checking
    Route::middleware(['auth:sanctum', 'ability:delivery-boy'])->group(function () {

    Route::get('/delivery_boy_dashboard', [DeliveryBoyDashboardController::class,'index']);

    Route::get('/logout', [DeliveryBoyDashboardController::class,'logout']);
    Route::get('/delivery_boy_profile', [DeliveryBoyDashboardController::class,'delivery_boy_profile']);

    //M4
    Route::get('/get_profile_details', [DeliveryBoyProfileController::class,'get_profile_details']);
    Route::post('/update_profile', [DeliveryBoyProfileController::class,'update_profile']);
    Route::post('/duty_on_off', [DeliveryBoyProfileController::class,'duty_on_off']);

    //M5
    Route::get('/get_all_orders', [DeliveryBoyOrderController::class,'get_all_orders']);
    Route::get('/get_new_orders', [DeliveryBoyOrderController::class,'get_new_orders']);
    Route::get('/get_ongoing_orders', [DeliveryBoyOrderController::class,'get_ongoing_orders']);
    Route::get('/get_completed_orders', [DeliveryBoyOrderController::class,'get_completed_orders']);
    Route::get('/order_details', [DeliveryBoyOrderController::class,'order_details']);
    Route::post('/update_delivery_status', [DeliveryBoyOrderController::class,'update_delivery_status']);
    Route::post('/pick_order', [DeliveryBoyOrderController::class,'pick_order']);
    Route::get('/get_reasons', [DeliveryBoyOrderController::class,'get_reasons']);


    Route::post('/return-order-to-store-in-exchange', [DeliveryBoyOrderController::class,'ReturnOrderToStoreOnExchnage']);

    //M10
    Route::get('/get_notifications_list',[NotificationController::class,'get_notifications_list']);
    Route::post('/mark_notification_as_read',[NotificationController::class,'mark_notification_as_read']);
    Route::post('/driver_mark_all_notification_as_read',[NotificationController::class,'driver_mark_all_notification_as_read']);
    Route::get('/get_notifications_count',[NotificationController::class,'get_notifications_count']);

    //m12
    Route::post('/raise_ticket', [DeliveryBoyDashboardController::class,'raise_ticket']);
    Route::get('/get_raised_tickets', [DeliveryBoyDashboardController::class,'get_raised_tickets']);

    //m13
    Route::post('/notification_on_off', [NotificationController::class,'notification_on_off']);

    });






});