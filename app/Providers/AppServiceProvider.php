<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            Request::setTrustedProxies(
                explode(',', config('trustedproxy.proxies')),
                config('trustedproxy.headers')
            );

            URL::forceScheme('https');
        }
    }
}
