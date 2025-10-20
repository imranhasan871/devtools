<?php

namespace Imran\DevTools;

use Illuminate\Support\ServiceProvider;
use Imran\DevTools\Contracts\CommandExecutorInterface;
use Imran\DevTools\Contracts\AccessControlInterface;
use Imran\DevTools\Services\ArtisanCommandService;
use Imran\DevTools\Services\AccessControlService;

class DevToolsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge config early so it's available in register()
        $this->mergeConfigFrom(__DIR__.'/../config/devtools.php', 'devtools');

        // Register service bindings
        $this->app->singleton(CommandExecutorInterface::class, ArtisanCommandService::class);
        
        $this->app->singleton(AccessControlInterface::class, function ($app) {
            return new AccessControlService(
                app: $app,
                config: config('devtools', [])
            );
        });
    }

    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/devtools.php' => config_path('devtools.php'),
        ], 'devtools-config');

        // Decide whether to enable devtools based on config
        $enabled = config('devtools.enabled');
        if (is_null($enabled)) {
            $enabled = in_array($this->app->environment(), config('devtools.environments', ['local']));
        }

        if ($enabled) {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
            $this->loadViewsFrom(__DIR__.'/../resources/views', 'devtools');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/devtools'),
            ], 'devtools-views');

            // Register middleware alias
            $router = $this->app->make('router');
            $router->aliasMiddleware('devtools.allowed', \Imran\DevTools\Http\Middleware\EnsureDevtoolsAllowed::class);
        }
    }
}
