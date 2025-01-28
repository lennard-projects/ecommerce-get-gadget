<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemsFactory> */
    use HasFactory;
    
    protected $fillable = ['order_id', 'product_id'];

    public function orders() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function products() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
