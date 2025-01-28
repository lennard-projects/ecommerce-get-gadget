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
        // $userId = Auth::user()->id;
        // dd($user);

        // dd($request->product_id);
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'session_id' => 'required'
        ]);

        // $shopping_session_id = Cookie::get('cartCookie');
        if (!$request->session_id) {
            return redirect()->route('user.home')->with('error', 'Session expired. Please try again.');
        }

        if ($validator->passes()) {

            $cartItemExist = CartItem::where('shopping_session_id', $request->session_id)->where('product_id', $request->product_id)->exists();
            if (!$cartItemExist) {
                $cart_item = new CartItem();
                $cart_item->shopping_session_id = $request->session_id;
                $cart_item->product_id = $request->product_id;
                // $cart_item->updated_at = now();
                $cart_item->save();
                // $cookie = Cookie::get('cartCookie');
                $shopping_session = ShoppingSession::where('id', $request->session_id)->first();
                $shopping_total = $shopping_session->total + $request->product_price;
                $shopping_session->total = $shopping_total;
                $shopping_session->update();
                // return redirect()->route('user.home')->with('success', 'Added to cart.');
                return response()->json([
                    'success' => 'Added to cart successfully.'
                ]);
                // return redirect()->route('user.home')->with('message', 'Added to Cart successfully.');
            } else {
                // return redirect()->route('user.home')->with('error', 'Product already exist in cart.');
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
        // $cartJoinProduct = Product::where('id', $cart->product_id)->get();
        // $product = Product::where('id', )
        // $product = Product::all();
        // dd($cart->product_id);
        if ($user) {
            $all = DB::table('products')
                ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                // ->select('cart_items.*', 'products.*', 'cart_items.id as cart_item_id', 'products.id as products_product_id')
                ->where('shopping_session_id', $shopping_session_id)
                ->get();
        } else {
            $all = DB::table('products')
                ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                // ->select('cart_items.*', 'products.*', 'cart_items.id as cart_item_id', 'products.id as products_product_id')
                ->where('shopping_session_id', $shopping_session_id)
                ->get();
        }

        // $all2 = DB::table('cart_items')
        // ->join('products', 'cart_items.product_id', '=', 'products.id')
        // // ->select('cart_items.*', 'products.*', 'cart_items.id as cart_item_id', 'products.id as products_product_id')
        // ->where('shopping_session_id', $shopping_session_id)
        // ->get();


        $grandTotal = 0;
        foreach ($all as $item) {
            $grandTotal += $item->price * $item->quantity;
        }
        // dd($total);
        // echo $all;
        return view('products.cart', [
            'cart' => $all,
            'grandTotal' => $grandTotal,
            'productsTotal' => $grandTotal
        ]);
    }

    public function increment(Request $request)
    {
        $shopping_session_id = Cookie::get('cartCookie');
        // $cart_item = CartItem::where('id', $request->id)->first();
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $cart_item = CartItem::where('id', $request->cart_item_id)->first();
        $shopping_session = ShoppingSession::where('id', $shopping_session_id)->first();
        $product = Product::where('id', $request->product_id)->first();
        // $cart_item = CartItem::where('id', $)
        // dd($request->product_id);
        // dd($product->price * $cart_item->quantity);
        $cart_products = CartItem::where('shopping_session_id', $shopping_session_id)->get();
        // $cart_products = CartItem::where('shopping_session_id', $shopping_session_id)->get();
        // $cartItemsWithTotal = $cart_products->map(function($item) {
        //     $item->total_price = $request->product_id * $item->quantity;
        //     return $item;
        // });


        if ($cart_item) {
            $cart_item->quantity += 1;
            $cart_item->update();
            // $total = $product->price * $cart_item->quantity;
            // $grandTotal = $total +
            // $shopping_session->total = $total;

            // $shopping_session->update();

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
        //     $all = DB::table('products')
        //     ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
        //     ->where('shopping_session_id', $shopping_session_id)
        //     ->get();


        //     $grandTotal = 0;
        // foreach ($all as $item) {
        //     $grandTotal += $item->price * $item->quantity;
        // }
        // return redirect()->route('user.cart')->with('success', 'Increment successfull.');
        // if ($cartItem) {
        //     // If item exists, increme nt the quantity
        //     $cartItem->quantity += $quantity;
        //     $cartItem->save();
        // } else {
        // If item doesn't exist, create a new cart item
        //     CartItem::create([
        //         'cart_id' => $cart->id,
        //         'product_id' => $productId,
        //         'quantity' => $quantity,
        //     ]);
        // }

        // Recalculate the total (optional)
        // $total = $cart->items->sum(function ($item) {
        //     return $item->product->price * $item->quantity;
        // });

        // Return the updated cart and total
        return response()->json([
            // 'cart' => $cart->load('items.product'),  // Load items with product data
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
            // $total = $product->price * $cart_item->quantity;
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

        // $cart_items = DB::table('products')
        //     ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
        //     ->where('shopping_session_id', $shopping_session_id)
        //     ->get();

        // $grandTotal = 0;
        // foreach ($cart_items as $item) {
        //     $grandTotal += $item->price * $item->quantity;
        // }

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
                // ->select('cart_items.*', 'products.*', 'cart_items.id as cart_item_id', 'products.id as products_product_id')
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
        dd($user);
    }
}
