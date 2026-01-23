<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\OrderInvoiceController;

require __DIR__.'/seller_web.php';
require __DIR__.'/user_web.php';
require __DIR__.'/admin_web.php';
require __DIR__.'/affiliate_userWeb.php';


Route::match(['get', 'post'], '/myfatoorah/{id}', [MyFatoorahController::class, 'index']);

Route::match(['get', 'post'], '/Invoice/{id}', [OrderInvoiceController::class, 'Invoice']);



  