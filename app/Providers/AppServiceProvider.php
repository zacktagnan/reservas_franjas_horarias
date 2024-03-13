<?php

namespace App\Providers;

use App\Models\BarberShop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Nuevas directivas de Blade personalizadas :: ini
        Blade::if('dateNotIsToday', function (Carbon $date) {
            return !$date->isToday();
        });

        Blade::if('dateWithinMaxFutureDays', function (Carbon $date, BarberShop $barberShop) {
            return $date->dayOfYear < (now()->dayOfYear + $barberShop->max_future_days);
        });
        // Nuevas directivas de Blade personalizadas :: fin
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
