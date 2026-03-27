<?php

return [
    'bot_id'   => env('TELEGRAM_BOT_ID'),
    'chat_ids' => array_values(array_unique(array_filter([
        env('TELEGRAM_CHAT_ID'),
        env('TELEGRAM_CHAT_ID_1'),
    ]))),
];
