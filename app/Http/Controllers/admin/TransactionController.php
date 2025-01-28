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

        // $transactions = Order::join('orders', 'id', '=', 'order_items.order_id');
        $transactions = DB::table('orders')
        ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
        ->leftJoin('payments', 'payments.id', '=', 'orders.payment_id')
        
        // ->select(['*', 'payments.created_at as payment_created_at', 'payments.updated_at as payment_updated_at', 'orders.id as id'])
        // ->select('orders.total', 'order_items.product_id')
        // ->select('orders.created_at as order_created_at', 'payments.created_at as payment_created_at')
        // ->addSelect(['*', 'payments.created_at as pca', 'orders.id as uid'])
        // ->addSelect(['*', 'payments.created_at as pca', 'orders.id as uid'])
        // ->select(['*', 'orders.id as aid'])
        // ->orderBy('aid', 'asc')
        // ->select(['orders.id', 'payments.id as pid', 'order_items.id as oiid'])
        // ->orderBy('orders.id', 'asc')
        ->select( 'orders.id as order_id', 'order_items.product_id as order_items_pid', 'payments.created_at as payment_created_at' ,'payments.id as pid')
        ->orderBy('payment_created_at')
        ->get();


        // $users = User::join('posts', 'users.id', '=', 'posts.user_id')
        //      ->select('users.id', 'users.name', 'posts.title')
        //      ->get();
        // $all = $transactions->join('payments', 'payments.id', '=', 'orders.payment_id');

        
        return $transactions;
        // dd($transactions);
        // var_dump($transactions);
        // return view('admin.transaction', [
        //     'transactions' => $transactions
        // ]);
    }
}
