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
            $seller = Auth::guard('seller')->user();

            
            // If store info not completed and not already on store info page
            if ($seller->store_information == '0') {

                return redirect()->route('seller.store_information', $seller->id);
            }
            
            // If bank info not completed and not already on bank info page
            if ($seller->bank_information == '0') {
                return redirect()->route('seller.upload_document', $seller->id);
            }

            // If admin verification pending and not already on review upload page
            if ($seller->admin_verify == '0') {
                return redirect()->route('seller.upload_review', $seller->id);
            }

            // If admin verification approved and not already on review submit page
            if ($seller->admin_verify == '1') {
                return redirect()->route('seller.review_submit_page', $seller->id);
            }

            return redirect()->route('seller.dashboard');
          

         return $next($request);

        }

        
        return $next($request);
    
    }

}