<?php

namespace App\Http\Middleware;

use App\Models\ShoppingSession;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SetCookieMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasCookie('cartCookie') && !Auth::user()) {
            $newShopppingSession = new ShoppingSession();
            $newShopppingSession->save();
            $sessionId = $newShopppingSession->id;
            $cookie = cookie('cartCookie', $sessionId, 20160);
            return $next($request)->withCookie($cookie);
        }

        if ($request->hasCookie('cartCookie') || Auth::user()) {
            if (Auth::user() && !$request->hasCookie('cartCookie')) {
                $shopping_session_user_id = ShoppingSession::where('user_id', Auth::user()->id)->exists();
                $shopping_session_id = ShoppingSession::where('user_id', Auth::user()->id)->first();
                $shopping_session = ShoppingSession::select('id')->find($shopping_session_id);
                if ($shopping_session_user_id) {
                    $shopping_session_id = ShoppingSession::where('user_id', Auth::user()->id)->first();
                    $shopping_session = ShoppingSession::select('id')->find($shopping_session_id)->first();
                    $cookie = cookie('cartCookie', $shopping_session->id, 20160);
                    $shopping_session->updated_at = now();
                    $shopping_session->update();
                    return $next($request)->withCookie($cookie);
                }
                if (!Auth::user() && $request->hasCookie('cartCookie')) {
                    $cookie = (int) Cookie::get('cartCookie');
                    $shoppingSession = ShoppingSession::select('id')->find($cookie);
                    $shoppingSession->updated_at = now();
                    $shoppingSession->update();
                    return $next($request);
                }
            }
            return $next($request);
        }
    }
}
