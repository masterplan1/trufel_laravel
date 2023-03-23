<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Cart;
use App\Models\Filling;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getCartItems();
        $fillings_ids = Arr::pluck($cartItems, 'filling_id');
        $cartItems = Arr::keyBy($cartItems, 'filling_id');

        $fillings = Filling::whereIn('id', $fillings_ids)->get();
        // $total = array_reduce($cartItems, fn($carry, $item) => $carry + $item['quantity']*$item['price'], 0);
        return view('cart.index', compact('cartItems', 'fillings'));
    }

    public function add(Request $request, Filling $filling)
    {
        $totalAmount = $request->post('totalAmount');
        // $totalPrice = $request->post('totalPrice');

        $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
        $isFound = false;
        foreach ($cartItems as &$cartItem) {
            if ($cartItem['filling_id'] === $filling->id) {
                $cartItem['weight'] = $filling->type()->weight_quantity === 'weight' ? $totalAmount : null;
                $cartItem['quantity'] = $filling->type()->weight_quantity === 'weight' ? 1 : $totalAmount;
                $isFound = true;
                break;
            }
        }
        if (!$isFound) {
            $cartItems[] = [
                'filling_id' => $filling->id,
                'weight' => $filling->type()->weight_quantity === 'weight' ? $totalAmount : null,
                'quantity' => $filling->type()->weight_quantity === 'weight' ? 1 : $totalAmount,
                'price' => $filling->unit_price
            ];
        }
        Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
        return response(['count' => Cart::getCountFromItems($cartItems)]);
    }
    public function remove(Request $request, Filling $filling)
    {
        $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
        foreach ($cartItems as $key => $cartItem) {
            if ($cartItem['filling_id'] === $filling->id) {
                unset($cartItems[$key]);
                break;
            }
        }
        Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
        return response(['count' => Cart::getCountFromItems($cartItems)]);
    }
    public function changeCandybarFilling(Request $request, Filling $filling)
    {
        $newFillingId = $request->post('new_filling_id');
        $newFilling = Filling::find($newFillingId);
        if ($newFilling->type()->is_candybar && $filling->type()->is_candybar) {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as &$cartItem) {
                if ($cartItem['filling_id'] === $filling->id) {
                    $cartItem['filling_id'] = $newFillingId;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
            return response('');
        }
        return false;
    }
}
