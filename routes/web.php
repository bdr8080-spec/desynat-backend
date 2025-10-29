<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/seller_web.php';


Route::get('/', function () {
    return view('welcome');
});


