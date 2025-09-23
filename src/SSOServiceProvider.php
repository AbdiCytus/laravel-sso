<?php

namespace OpenSynergic\LaravelSSO;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use OpenSynergic\LaravelSSO\Middleware\ClientKeyMiddleware;
use OpenSynergic\LaravelSSO\Middleware\InternalAuth;

class SSOServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravelsso.php', 'laravelsso');
    }

    public function boot()
    {
        $this->app['router']->aliasMiddleware('client_api_key', ClientKeyMiddleware::class);

        //Routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        // Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'unauthorized');
    }
}
