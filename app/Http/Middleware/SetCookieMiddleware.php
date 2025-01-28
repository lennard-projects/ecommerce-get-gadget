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
        // Auth::user()->id;
        // if (Auth::user()) {
            // $shopping_session_user_id = ShoppingSession::where('user_id', Auth::user()->id)->first();
            // $shopping_session_id = ShoppingSession::where('user_id', Auth::user()->id);

        // }
        if (!$request->hasCookie('cartCookie') && !Auth::user()) {
            $newShopppingSession = new ShoppingSession();
            // if(Auth::user()) {
            //     $user_id = Auth::user()->id;
            //     $newShopppingSession->user_id = $user_id;
            // }
            $newShopppingSession->save();
            $sessionId = $newShopppingSession->id;
            // $id = $newShopppingSession->id;
            $cookie = cookie('cartCookie', $sessionId, 20160);
            return $next($request)->withCookie($cookie);
        }

        if ($request->hasCookie('cartCookie') || Auth::user()) {
            if (Auth::user() && !$request->hasCookie('cartCookie')) {
                // $cart_item = CartItem::where('id', $request->cart_item_id)->first();
                $shopping_session_user_id = ShoppingSession::where('user_id', Auth::user()->id)->exists();
                $shopping_session_id = ShoppingSession::where('user_id', Auth::user()->id)->first();
                $shopping_session = ShoppingSession::select('id')->find($shopping_session_id);
                if ($shopping_session_user_id) {
                    // $newShopppingSession = new ShoppingSession();
                    // $newShopppingSession->save();
                    // $sessionId = $newShopppingSession->id;
                    // // dd($sessionId);
                    // $cookie = cookie('cartCookie', $sessionId, 20160);
                    // return $next($request)->withCookie($cookie);
                    $shopping_session_id = ShoppingSession::where('user_id', Auth::user()->id)->first();
                    $shopping_session = ShoppingSession::select('id')->find($shopping_session_id)->first();
                    $cookie = cookie('cartCookie', $shopping_session->id, 20160);
                    $shopping_session->updated_at = now();
                    $shopping_session->update();
                    return $next($request)->withCookie($cookie);
                } else {
                    // dd($shopping_session_user_id->id);
                    // $cookie = cookie('cartCookie', $shopping_session->id, 20160);
                    // $shopping_session->user_id = Auth::user()->id;

                //     $shopping_session_id = ShoppingSession::where('user_id', Auth::user()->id)->first();
                //     $shopping_session = ShoppingSession::select('id')->find($shopping_session_id)->first();
                //     $cookie = cookie('cartCookie', $shopping_session->id, 20160);
                // // dd($cookie);
                //     $shopping_session->updated_at = now();
                //     $shopping_session->update();
                //     return $next($request)->withCookie($cookie);
                }
                // dd($shopping_session_user_id);

            }
            if (!Auth::user() && $request->hasCookie('cartCookie')) {
                $cookie = (int) Cookie::get('cartCookie');
                $shoppingSession = ShoppingSession::select('id')->find($cookie);
                // $cookie = (int) Cookie::get('cartCookie');
                // dd(is_int($cookie));
                // dd($shoppingSession->id);
                // if (Auth::user()) {
                //     $user_id = Auth::user()->id;
                //     $shoppingSession->user_id = $user_id;
                // }
                $shoppingSession->updated_at = now();
                $shoppingSession->update();
                return $next($request);
            }

            // if (Auth::user() && $request->hasCookie('cartCookie')) {
            //     // Cookie::forget('cartCookie');
            //     // $shopping_session_user_id = ShoppingSession::where('user_id', Auth::user()->id)->exists();
            //     $shopping_session_id = ShoppingSession::where('user_id', Auth::user()->id)->first();
            //     $shopping_session = ShoppingSession::select('id')->find($shopping_session_id)->first();
            //     $cookie = cookie('cartCookie', $shopping_session->id, 20160);
            //     // dd($cookie);
            //     $shopping_session->updated_at = now();
            //     $shopping_session->update();
            //     return $next($request)->withCookie($cookie);
                // $shoppingSession = ShoppingSession::select('id')->find($cookie);
                // $cookie = (int) Cookie::get('cartCookie');
                // dd(is_int($cookie));
                // dd($shoppingSession->id);
                // if (Auth::user()) {
                //     $user_id = Auth::user()->id;
                //     $shoppingSession->user_id = $user_id;
                // }
                // $shopping_session->updated_at = now();
                // $shopping_session->update();
            // }
            // $shoppingSession->updated_at = now();
            // $shoppingSession->update();
        }

        // if(Auth::user()) {
        //     $newShopppingSession = new ShoppingSession();
        //     $user_id = Auth::user()->id;
        //     $newShopppingSession->user_id = $user_id;
        // }
        return $next($request);


        // if ($request->hasCookie('cartCookie')) {
        // $cookie = Cookie::get('cartCookie');
        // $shoppingSession = ShoppingSession::where('userId', '=', null)->where('updated_at', '<', now()->subMinutes(5));
        // $shoppingSession->delete();
        // echo $cookie;
        // return $next($request);
        // }





        // $cookie = cookie('cartCookie', null, 5);


    }
}
