<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\MyFatoorahController;

require __DIR__.'/seller_web.php';
require __DIR__.'/user_web.php';
require __DIR__.'/admin_web.php';


Route::match(['get', 'post'], '/myfatoorah/{id}', [MyFatoorahController::class, 'index']);
  