<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cookies
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(!$request->cookie('cartCookie')) {
        //     return response('')->cookie(
        //         'cartCookie', 'dasdsssss', 1
        //     );
        // }
        return $next($request);
    }
}
