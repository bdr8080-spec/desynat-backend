<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use App\Http\Middleware\RedirectIfSellerAuthenticated;
use App\Http\Middleware\LoginCheck;

use App\Http\Middleware\DisableBackBtn;
use App\Http\Middleware\SellerAuthenticated;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'abilities' => CheckAbilities::class,
            'ability'  => CheckForAnyAbility::class,
            'is_seller'=>RedirectIfSellerAuthenticated::class,
            'guest_user'=>LoginCheck::class,
            'prevent-back-history' => DisableBackBtn::class, // Add this line
            'seller_login' =>SellerAuthenticated::class
               
        ]);

       

    })

    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->alias([
            'is_seller'=>RedirectIfSellerAuthenticated::class    
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();