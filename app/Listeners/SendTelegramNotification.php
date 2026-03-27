<?php

namespace App\Listeners;

use App\Events\OrderStore;
use App\Http\Helpers\Telegram;
use Illuminate\Support\Facades\Log;

class SendTelegramNotification
{
    public function __construct(protected Telegram $telegram)
    {
        //
    }

    public function handle(OrderStore $event): void
    {
        $chatIds = config('telegram_chat_ids');

        try {
            $order = $event->order->load([
                'orderDetail',
                'orderItems.filling.category.type',
            ]);

            $message = (string) view('telegram.index', compact('order'));

            foreach ($chatIds as $chatId) {
                $this->telegram->sendMessage($chatId, $message);
            }
        } catch (\Throwable $th) {
            Log::error('Telegram notification failed: ' . $th->getMessage(), [
                'order_id' => $event->order->id ?? null,
            ]);
        }
    }
}
