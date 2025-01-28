<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    public function index() {
        $products = Product::query()->paginate(12)->onEachSide(1);
        // $value = Cookie::get('cartCookie');
        // echo $value;
        return view('products.index', [
            'products' => $products
        ]);
        // $products = Product::all();
        // return $products;
        // return view('products.index', [
        //     'products' => $products
        // ])->response('')->cookie('name','value',1);
        // return response(view('products.index', ['products' => $products]))->cookie('name','valuesss', 1);
    }
}
