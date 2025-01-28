<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'stock',
        'price',
        'product_image'
    ];

    public function scopeFilter($query, array $filters) {
        // dd($filters['search']);
        if($filters['search'] ?? false) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }
        // if($filters['search'] && $filters['page_num']) {
        //     $query->where('name', 'like', '%' . request('search') . '%');
        // }s
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems() {
        return $this->hasMany(OrderItems::class, 'product_id');
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class, 'product_id');
    }
}
