<?php

namespace Imran\DevTools\Tests\Feature;

use Orchestra\Testbench\TestCase;

class DevToolsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [\Imran\DevTools\DevToolsServiceProvider::class];
    }

    public function test_clean_route_returns_json_in_local()
    {
        $this->app->detectEnvironment(function () {
            return 'local';
        });

        $response = $this->get('/dev/clean');

        $response->assertStatus(200);
        $response->assertJsonStructure(['ok', 'environment', 'results']);
    }
}
