<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\OrderInvoiceController;
use Illuminate\Support\Facades\Artisan;



require __DIR__.'/seller_web.php';
require __DIR__.'/user_web.php';
require __DIR__.'/admin_web.php';
require __DIR__.'/affiliate_userWeb.php';

Route::get('optimize',function(){
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');

    return 'Application optimized successfully!';
});


Route::match(['get', 'post'], '/myfatoorah/{id}', [MyFatoorahController::class, 'index']);

Route::match(['get', 'post'], '/Invoice/{id}', [OrderInvoiceController::class, 'Invoice']);



  Route::get('/apple-app-site-association', function () {
    $aasa = [
        "applinks" => [
            "details" => [
                [
                    "appID" => "6QKUQGN93F.com.app.DesynatUser",
                    // "paths" => ["/user/product/detail-page/*"]
                    "paths" => 
                    [
                        "*"
                //   "/user/product/*",
                //   "/user/store-details/*" 
                  ]
                ]
            ]
        ]
    ];
 
    return response()->json($aasa, 200, [], JSON_UNESCAPED_SLASHES);
});