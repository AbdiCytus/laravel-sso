<?php

namespace OpenSynergic\LaravelSSO;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class LaravelSsoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravelsso.php', 'laravelsso');
    }

    public function boot()
    {
        // Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'unauthorized');

        // Config publish
        $this->publishes([
            __DIR__ . '/../config/laravelsso.php' => config_path('laravelsso.php'),
        ], 'laravelsso-config');
    }
}
