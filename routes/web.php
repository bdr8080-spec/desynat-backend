<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/seller_web.php';
require __DIR__.'/user_web.php';



Route::get('/', function () {
    return view('welcome');
});