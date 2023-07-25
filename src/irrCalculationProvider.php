<?php

namespace codetimer\irr;

use Illuminate\Support\ServiceProvider;

class irrCalculationProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->make('codetimer\irr\irrCalculationController');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        include __DIR__.'/routes.php';
    }
}
