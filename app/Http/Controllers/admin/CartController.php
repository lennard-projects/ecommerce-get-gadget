<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ShoppingSession;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function destroyUnusedCarts() {
        $shoppingSession = ShoppingSession::where('user_id', '=', null)->where('updated_at', '<', now()->subDays(14));
        $shoppingSession->delete();
        return redirect()->route('admin.products')->with('success', 'All unused carts successfully deleted.');
    }
}
