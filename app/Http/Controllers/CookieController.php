<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class CookieController extends Controller
{
    public function setCookie(Request $request){
        //session id
        // $minutes = 20160;
        // // $uuid = Str::uuid();
        // return response('')->cookie(
        //     'cartCookie', 'dasd', $minutes
        // );
     }

     public function getCookie(Request $request){
        // $value = $request->cookie('cartCookie');
        $value = Cookie::get('cartCookie');
        echo $value;
     }

    public function deleteCookie() {
        return response('cookie deleted.')->cookie('cartCookie', null, -1);
    }
}
