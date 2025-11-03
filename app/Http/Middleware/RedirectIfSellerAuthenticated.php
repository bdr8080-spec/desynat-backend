<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


use Illuminate\Support\Facades\Auth;

class RedirectIfSellerAuthenticated
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
        
            $Seller_id=Auth::guard('seller')->user();

            if($Seller_id->store_information=='0'){
                return redirect()->route('seller.store_information',$Seller_id->id);
            }

            if($Seller_id->bank_information=='0'){
                return redirect()->route('seller.upload_document',$Seller_id->id);
            }
            
            if($Seller_id->admin_verify=='0'){
                return redirect()->route('seller.upload_review',$Seller_id->id);
            }

            if($Seller_id->admin_verify=='1'){
                return redirect()->route('seller.review_submit_page',$Seller_id->id);
            }
            
            // return redirect()->route('seller.review_submit_page',$Seller_id);
        }


        return $next($request);
    }
}