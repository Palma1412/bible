<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_uuid', 'product_id', 'quantity'];

    public function cart() {
        return $this->belongsTo(Cart::class, 'cart_uuid', 'uuid');
    }
}

