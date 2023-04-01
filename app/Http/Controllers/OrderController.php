<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Events\OrderStore;
use App\Http\Helpers\Cart;
use App\Models\Filling;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    public function index()
    {
        list($totalPrice, $candybarFound, $cakeFound) = self::prepareCartItems();
      
        $timeOffset = $candybarFound ? 'tomorrow + 2day' : ($cakeFound ? 'tomorrow + 1day' : 'tomorrow');
        
        $date = (new \DateTime($timeOffset))->format('Y-m-d');

        return view('order.index', compact('date', 'totalPrice'));
    }

    public function checkout(Request $request){
        $validated = $request->validate([
            'customer_name' => 'required|min:3',
            'customer_phone' => 'required',
            'order_date' => 'required'
        ]);
        $cartItems = Cart::getCartItems();

        $order = Order::create([
            'total_price' => self::prepareCartItems()[0],
            'status' => OrderStatus::New->value
        ]);
        
        foreach($cartItems as $cartItem){
            OrderItem::create([
                'order_id' => $order->id,
                'filling_id' => $cartItem['filling_id'],
                'unit_price' => $cartItem['price'],
                'weight' => isset($cartItem['weight']) ? $cartItem['weight'] : null,
                'quantity' => $cartItem['quantity'],
            ]);
        }
        $validated['order_id'] = $order->id;
        OrderDetail::create($validated);
        
        // clear cookies
        Cookie::queue(Cookie::forget('cart_items'));
        // to do telegram notification
        OrderStore::dispatch($order);
        return redirect('/')->with('message', 'Ваше замовлення створено!');
    }

    private static function prepareCartItems(){
        $cartItems = Cart::getCartItems();
        $ids = Arr::pluck($cartItems, 'filling_id');
        $fillings = Filling::whereIn('id', $ids)->get();
        $fillings = Arr::keyBy($fillings, 'id');
        $candybarFound = false;
        $cakeFound = false;
        
        foreach ($cartItems as &$item){
            if($fillings[$item['filling_id']]){
                if($fillings[$item['filling_id']]->type()->weight_quantity === 'weight'){
                    $item['isCake'] = true;
                    $cakeFound = true;
                }
                if($fillings[$item['filling_id']]->type()->is_candybar === 1){
                    $candybarFound = true;
                    // $item['isCandybar'] = true;
                }
            }
        }
        $totalPrice = array_reduce($cartItems, fn($carry, $item) => 
                $carry + $item['quantity']*$item['price']*(isset($item['isCake']) ? $item['weight'] : 1), 
            0);
        return [$totalPrice, $candybarFound, $cakeFound];
    }
}
