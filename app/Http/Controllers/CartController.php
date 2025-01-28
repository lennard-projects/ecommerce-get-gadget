<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShoppingSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'session_id' => 'required'
        ]);
        if (!$request->session_id) {
            return redirect()->route('user.home')->with('error', 'Session expired. Please try again.');
        }
        if ($validator->passes()) {
            $cartItemExist = CartItem::where('shopping_session_id', $request->session_id)->where('product_id', $request->product_id)->exists();
            if (!$cartItemExist) {
                $cart_item = new CartItem();
                $cart_item->shopping_session_id = $request->session_id;
                $cart_item->product_id = $request->product_id;
                $cart_item->save();
                $shopping_session = ShoppingSession::where('id', $request->session_id)->first();
                $shopping_total = $shopping_session->total + $request->product_price;
                $shopping_session->total = $shopping_total;
                $shopping_session->update();
                return response()->json([
                    'success' => 'Added to cart successfully.'
                ]);
            } else {
                return response()->json([
                    'exist' => 'Product already exist in cart.'
                ]);
            }
        }
    }

    public function showCart()
    {
        $user = Auth::user();
        $shopping_session_id = Cookie::get('cartCookie');
        $cart = CartItem::where('shopping_session_id', $shopping_session_id)->get();
        if ($user) {
            $all = DB::table('products')
                ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                ->where('shopping_session_id', $shopping_session_id)
                ->get();
        } else {
            $all = DB::table('products')
                ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                ->where('shopping_session_id', $shopping_session_id)
                ->get();
        }
        $grandTotal = 0;
        foreach ($all as $item) {
            $grandTotal += $item->price * $item->quantity;
        }
        return view('products.cart', [
            'cart' => $all,
            'grandTotal' => $grandTotal,
            'productsTotal' => $grandTotal
        ]);
    }

    public function increment(Request $request)
    {
        $shopping_session_id = Cookie::get('cartCookie');
        $cart_item = CartItem::where('id', $request->cart_item_id)->first();
        $shopping_session = ShoppingSession::where('id', $shopping_session_id)->first();
        $product = Product::where('id', $request->product_id)->first();
        if ($cart_item) {
            $cart_item->quantity += 1;
            $cart_item->update();
            $all = DB::table('products')
                ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                ->where('shopping_session_id', $shopping_session_id)
                ->get();
            $grandTotal = 0;
            foreach ($all as $item) {
                $grandTotal += $item->price * $item->quantity;
            }
            $shopping_session->total = $grandTotal;

            $shopping_session->update();
        }
        return response()->json([
            'quantity' => $cart_item->quantity,
            'price' => $shopping_session->total,
            'grandTotal' => $grandTotal,
            'productsTotal' => $grandTotal,
            'stock' => $product->stock,
            'message' => 'Quantity updated successfully',
            'success' => 'success'
        ]);
    }

    public function decrement(Request $request)
    {
        $shopping_session_id = Cookie::get('cartCookie');
        $shopping_session = ShoppingSession::where('id', $shopping_session_id)->first();
        $cart_item = CartItem::where('id', $request->cart_item_id)->first();
        $product = Product::where('id', $request->product_id)->first();
        if ($cart_item) {
            $cart_item->quantity -= 1;
            $cart_item->update();
            $cart_items = DB::table('products')
                ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                ->where('shopping_session_id', $shopping_session_id)
                ->get();
            $grandTotal = 0;
            foreach ($cart_items as $item) {
                $grandTotal += $item->price * $item->quantity;
            }
            $shopping_session->total = $grandTotal;
            $shopping_session->update();
        }
        return response()->json([
            'quantity' => $cart_item->quantity,
            'grandTotal' => $grandTotal,
            'productsTotal' => $grandTotal,
            'price' => $shopping_session->total,
            'stock' => $product->stock,
            'message' => 'Quantity updated successfully.',
            'success' => 'success'
        ]);
    }

    public function removeItem(Request $request)
    {
        $cart_item = CartItem::where('id', $request->cart_item_id);
        $cart_item->delete();
        $shopping_session_id = Cookie::get('cartCookie');
        $count = DB::table('products')
                ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                ->where('shopping_session_id', $shopping_session_id)
                ->count();
        return response()->json([
            'success' => 'Deleted successfully.',
            'count' => $count
        ]);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
    }
}
