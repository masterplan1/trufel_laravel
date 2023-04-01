<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Http;

class Telegram
{

  const TELEGRAM_URL = 'https://api.telegram.org/bot';

  public function __construct(protected Http $http, protected $botId){}
  
  public function sendMessage($chat_id, $message = 'Нове замовлення')
  {
    // var_dump($this->http);exit;
    $this->http::post(self::TELEGRAM_URL . $this->botId . "/sendMessage", [
      'chat_id' => $chat_id,
      'text' => $message,
      'parse_mode' => 'HTML',
    ]);
  }
}
