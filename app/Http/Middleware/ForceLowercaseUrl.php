<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForceLowercaseUrl
{
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        $fullUrl = $request->fullUrl();

        // Redirect only if path contains uppercase
        if ($path !== Str::lower($path)) {
            return redirect()->to(Str::lower($fullUrl), 301);
        }

        return $next($request);
    }
}