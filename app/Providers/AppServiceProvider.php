<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\StockUpdated;
use App\Jobs\CheckLowStockJob;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') !== 'local' || request()->header('x-forwarded-host')) {
            URL::forceScheme('https');
        }

        Event::listen(StockUpdated::class, function (StockUpdated $event) {
            CheckLowStockJob::dispatch($event->product_id, $event->location_id);
        });
    }
}
