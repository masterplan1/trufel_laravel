<?php

namespace App\Listeners;

use App\Events\OrderStore;
use App\Http\Helpers\Telegram;
use App\Models\Filling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;

class SendTelegramNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(protected Telegram $telegram)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStore $event): void
    {
        $chatIds = config('telegram_chat_ids');
        try {
            $order = $event->order;
            $orderItems = $order->orderItems()->get()->toArray();
            $orderItems = Arr::pluck($orderItems, 'filling_id');
            $fillings = Filling::whereIn('id', $orderItems)->get()->toArray();
            $fillings = Arr::keyBy($fillings, 'id');
            // $id = $order->id;
            // $totalPrice = $order->total_price;
            // $customerName = $order->orderDetail->customer_name;
            // $customerName = $order->orderDetail->customer_phone;
            $this->telegram->sendMessage($chatIds[0], (string)view('telegram.index', compact('order', 'fillings')));
        } catch (\Throwable $th) {
            // throw $th;
        }
        
        
    }
}
