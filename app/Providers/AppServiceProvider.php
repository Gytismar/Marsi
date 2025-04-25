<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            $proxies = explode(',', config('trustedproxy.proxies', ''));

            $headers = config('trustedproxy.headers', SymfonyRequest::HEADER_FORWARDED);

            SymfonyRequest::setTrustedProxies($proxies, $headers);

            URL::forceScheme('https');
        }
    }
}
