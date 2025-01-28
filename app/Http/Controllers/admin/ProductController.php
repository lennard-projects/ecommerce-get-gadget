<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function products() {
        $products = Product::all();
    }

    public function index() {
        return view('admin.products', [
            'products' => Product::filter(request(['search']))->paginate(5)->onEachSide(1)
        ]);
    }

    public function create() {
        return view('admin.createProduct');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required',
            'stock' => 'required|integer',
            'price' => 'required|integer'
        ]);
        if($validator->passes()) {
            if(Auth::guard('admin')->user()->role != 'admin') {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.createProduct')->with('error', 'You are not authorized to access this page.');
            } else {
                $product = new Product();
                $product->user_id = Auth::guard('admin')->user()->id;
                $product->name = $request->name;
                $product->description = $request->description;
                $product->stock = $request->stock;
                $product->price = $request->price;
                if($request->hasFile('product_image')) {
                    $product->image_path = $request->file('product_image')->store('storage/products', 'public');
                }
                $product->save();
                return redirect()->route('admin.dashboard')->with('success', 'Product created successfully.');
            }
        } else {
            return redirect()->route('admin.createProduct')->withInput()->withErrors($validator);
        }
    }

    public function edit(Product $product) {
        return view('admin.editProduct', [
            'product' => $product
        ]);
    }

    public function update(Product $product, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'stock' => 'required|integer',
            'price' => 'required'
        ]);

        

        if($validator->passes()) {
            if(Auth::guard('admin')->user()->role != 'admin') {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
            } else {
                $product->name = $request->name;
                $product->description = $request->description;
                $product->stock = $request->stock;
                $product->price = $request->price;
                if($request->hasFile('product_image')) {
                    $product->image_path = $request->file('product_image')->store('products', 'public');
                }
                $product->update();
                return redirect()->route('admin.editProduct', ['product' => $product->id])->with('success', 'Product updated successfully.');
            }
        } else {
            return redirect()->route('admin.editProduct', ['product' => $product->id])->withInput()->withErrors($validator);
        }
    }

    public function destroy(Product $product) {
        if(Auth::guard('admin')->user()->role == 'admin') {
            $product->delete();
            return redirect()->route('admin.products')->with('success', 'Deleted successfully.');
        } else {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
        }
    }

    public function show(Product $product) {
        return view('admin.showProduct', [
            'product' => $product
        ]);
    }
}
