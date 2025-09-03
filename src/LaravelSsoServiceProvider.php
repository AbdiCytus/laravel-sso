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
        //Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        // Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'unauthorized');
    }
}
