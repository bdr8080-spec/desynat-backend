<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


use Illuminate\Support\Facades\Auth;

class SellerAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    public function handle($request, Closure $next, $guard = 'seller')
    {

        if (Auth::guard('seller')->check()) {   
          $seller = Auth::guard('seller')->user();
             
          return $next($request);
          
        }else{
            return redirect()->route('seller.login');
        }
        
        return $next($request);
    
    }

}