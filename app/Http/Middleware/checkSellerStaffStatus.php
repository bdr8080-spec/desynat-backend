<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Auth;

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

    if(Auth::Guard('seller')->check()){

        $seller_details=Auth::Guard('seller')->user();

        if($seller_details->type=='1' &&  $seller_details->is_block==1){
           
            Auth::guard('seller')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            
            return redirect()->route('seller.login');
          

            }

    }





        return $next($request);
    }
}
