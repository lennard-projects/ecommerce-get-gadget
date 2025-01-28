<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingSession extends Model
{
    /** @use HasFactory<\Database\Factories\ShoppingSessionFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'total'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
