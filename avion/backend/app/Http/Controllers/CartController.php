<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function getActiveCart() {
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'active'],
            ['uuid' => Str::uuid()]
        );

        $cart->load('items');

        return response()->json($cart);
    }

    public function addItem(Request $request) {
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'active'],
            ['uuid' => Str::uuid()]
        );

        $item = CartItem::updateOrCreate(
            ['cart_uuid' => $cart->uuid, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity ?? 1]
        );

        return response()->json($item);
    }

    public function getCart() {
        $cart = Cart::where('user_id', auth()->id())
            ->where('status', 'active')
            ->with('items')
            ->first();

        return response()->json($cart);
    }

    public function checkout() {
        $cart = Cart::where('user_id', auth()->id())
            ->where('status', 'active')
            ->firstOrFail();

        $cart->update(['status' => 'submitted']);

        return response()->json(['message' => 'Order placed']);
    }

}
