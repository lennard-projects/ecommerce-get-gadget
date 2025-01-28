<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\ShoppingSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login()
    {
        return view('users.login');
    }

    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'contact' => 'required',
            'address' => 'required'
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->contact = $request->contact;
            $user->address = $request->address;
            $user->role = 'customer';
            $user->save();
            return redirect()->route('user.login')->with('success', 'Registered successfully.');
        } else {
            return redirect()->route('user.create')->withInput()->withErrors($validator);
        }
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                if (Auth::user()->role != 'customer') {
                    Auth::logout();
                    return redirect()->route('user.login')->with('error', 'You are not authorized to access this page.');
                } else {
                    $session_cookie_id = Cookie::get('cartCookie');
                    $cart_items = CartItem::where('shopping_session_id', $session_cookie_id)->get();
                    if ($cart_items) {
                        $shopping_session_user = ShoppingSession::where('user_id', Auth::user()->id)->first();
                        foreach ($cart_items as $cart_item) {
                            $product_exist_guest = CartItem::where('shopping_session_id', $session_cookie_id)->where('product_id', $cart_item->product_id)->exists();
                            $product_exist_user = CartItem::where('shopping_session_id', $shopping_session_user->id)->where('product_id', $cart_item->product_id)->exists();
                            $shopping_session = ShoppingSession::where('user_id', Auth::user()->id)->first();
                            if ($product_exist_guest && $product_exist_user) {
                            } else {
                                $cart_item->shopping_session_id = $shopping_session->id;
                                $cart_item->update();
                            }
                        }
                        Cookie::forget('cartCookie');
                        $cookie = cookie('cartCookie', $shopping_session_user->id, 20160);
                        $shopping_session_user->updated_at = now();
                        $shopping_session_user->update();
                    }
                    return redirect()->route('user.home')->with('success', 'Signed in successfully.')->withCookie($cookie);
                }
            } else {
                return redirect()->route('user.login')->with('error', 'Either email or password are incorrect.');
            }
        } else {
            return redirect()->route('user.login')->withInput()->withErrors($validator);
        }
    }

    public function logout()
    {
        Auth::logout();
        Cookie::forget('cartCookie');
        $newShopppingSession = new ShoppingSession();
        $newShopppingSession->save();
        $sessionId = $newShopppingSession->id;
        $cookie = cookie('cartCookie', $sessionId, 20160);
        return redirect()->route('user.login')->withCookie(Cookie::forget('cartCookie'))->withCookie($cookie);
    }
}
