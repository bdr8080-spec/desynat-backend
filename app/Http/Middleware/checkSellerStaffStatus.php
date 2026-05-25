<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkSellerStaffStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

    $seller_data=$request->user();
    
    if($seller_data){
    if($seller_data->is_block==1){
      $request->user()->currentAccessToken()->delete();
    }

    }




        return $next($request);
    }
}
