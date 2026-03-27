<?php

namespace App\Providers;

use App\Http\Helpers\Telegram;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use App\View\Composers\MetaComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        EventServiceProvider::disableEventDiscovery();

        $this->app->bind(Telegram::class, function ($app){
            return new Telegram(new Http(), config('telegram.bot_id'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.app-layout', MetaComposer::class);

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
