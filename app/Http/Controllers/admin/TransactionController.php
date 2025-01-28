<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function transactions() {
        $transactions = DB::table('orders')
        ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
        ->leftJoin('payments', 'payments.id', '=', 'orders.payment_id')
        ->select( 'orders.id as order_id', 'order_items.product_id as order_items_pid', 'payments.created_at as payment_created_at' ,'payments.id as pid')
        ->orderBy('payment_created_at')
        ->get();
        return $transactions;
    }
}
