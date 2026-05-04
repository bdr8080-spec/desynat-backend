<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableBackBtn
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     */
//     public function handle(Request $request, Closure $next): Response
//     {

// $response = $next($request);


// $previousUrl = url()->previous(); // e.g. https://yourdomain.com/user/profile?tab=info

// // $path = parse_url($previousUrl, PHP_URL_PATH); // gives /user/profile

// $path = trim(parse_url($previousUrl, PHP_URL_PATH), '/');


// if ($request->routeIs('seller.all_plans')) {
//     return redirect()->route('seller.all_plans');
// }

// return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
//             ->header('Pragma', 'no-cache')
//             ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');




// // return $response;

//                     }

// public function handle(Request $request, Closure $next): Response
// {
//     $response = $next($request);

//     // Disable caching
//     $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
//              ->header('Pragma', 'no-cache')
//              ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

//     return $response;
// }

public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);

    // Only modify headers if method exists
    if (method_exists($response, 'header')) {
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                 ->header('Pragma', 'no-cache')
                 ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

    return $response;
}


}