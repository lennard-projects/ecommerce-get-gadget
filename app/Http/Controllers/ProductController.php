<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    public function index() {
        $products = Product::query()->paginate(12)->onEachSide(1);
        return view('products.index', [
            'products' => $products
        ]);
    }
}
