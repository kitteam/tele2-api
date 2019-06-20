<?php

namespace Tele2Api\Providers;

use Illuminate\Support\ServiceProvider;

class Tele2ServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->registerConfig();
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/tele2.php' => config_path('tele2.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../../config/tele2.php', 'tele2'
        );
    }
}
