<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Cart;
use App\Models\Filling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function add(Request $request, Filling $filling){
        $totalAmount = $request->post('totalAmount');
        $totalPrice = $request->post('totalPrice');

        $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
        $isFound = false;
        foreach($cartItems as &$cartItem){
            if($cartItem['filling_id'] === $filling->id){
                $cartItem['weight'] = $filling->type()->weight_quantity === 'weight' ? $totalAmount : null;
                $cartItem['quantity'] = $filling->type()->weight_quantity === 'weight' ? 1 : $totalAmount;
                $isFound = true;
                break;
            }
        }
        if(!$isFound){
            $cartItems[] = [
                'filling_id' => $filling->id,
                'weight' => $filling->type()->weight_quantity === 'weight' ? $totalAmount : null,
                'quantity' => $filling->type()->weight_quantity === 'weight' ? 1 : $totalAmount,
                'price' => $filling->unit_price
            ];
        }
        Cookie::queue('cart_items', json_encode($cartItems), 60*24*30);
        return response(['count' => Cart::getCountFromItems($cartItems)]);
    }
}
