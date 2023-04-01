<?php

namespace App\Providers;

use App\Http\Helpers\Telegram;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Telegram::class, function ($app){
            return new Telegram(new Http(), env('TELEGRAM_BOT_ID'), env('TELEGRAM_CHAT_ID'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
