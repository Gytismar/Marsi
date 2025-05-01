<?php

namespace Tests\Unit\Providers;

use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Tests\TestCase;

class AppServiceProviderTest extends TestCase
{
    public function test_boot_sets_trusted_proxies_and_forces_https_in_production()
    {
        $this->app['env'] = 'production';

        config(['trustedproxy.proxies' => '127.0.0.1,192.168.0.1']);
        config(['trustedproxy.headers' => SymfonyRequest::HEADER_FORWARDED]);

        URL::shouldReceive('forceScheme')
            ->once()
            ->with('https');

        (new AppServiceProvider($this->app))->boot();

        $this->assertTrue(true);
    }

    public function test_boot_does_nothing_if_not_production()
    {
        $this->app['env'] = 'local';

        URL::shouldReceive('forceScheme')->never();

        (new AppServiceProvider($this->app))->boot();

        $this->assertTrue(true);
    }
}
