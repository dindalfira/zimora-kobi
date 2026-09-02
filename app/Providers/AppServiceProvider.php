<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Carbon::setLocale('id');
        // if(config('app.env') === 'local') {
        //     URL::forceScheme('https');
        // }
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

}
