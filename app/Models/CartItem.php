<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory;

    protected $fillable = ['shopping_session_id', 'product_id', 'quantity'];

    public function shoppingSession() {
        return $this->belongsTo(ShoppingSession::class, 'shopping_session_id');
    }

    public function products() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
