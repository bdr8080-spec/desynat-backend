<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\PlanController;


Route::group(['prefix'=>'admin'], function(){

    Route::match(['get','post'],'/login', [AuthController::class, 'adminLogin'])->name('adminLogin');
    Route::match(['get','post'],'/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
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
        Route::get('/manage-cities', [CountryController::class, 'manageCities'])->name('manageCities');
        Route::get('/manage-zones', [CountryController::class, 'manageZones'])->name('manageZones');

        //seller management
        Route::get('/seller-management', [SellerController::class, 'sellerManagement'])->name('sellerManagement');

        //subscription plan management
        Route::get('/plan-management', [PlanController::class, 'planManagement'])->name('planManagement');
        Route::get('/manage-plans', [PlanController::class, 'managePlans'])->name('managePlans');

    });

});