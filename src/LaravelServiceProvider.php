<?php

namespace PodPoint\Reviews;

use PodPoint\Reviews\Cache\LaravelCacheAdapter;
use Psr\SimpleCache\CacheInterface;

/**
 * Class ServiceProvider.
 */
class LaravelServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/review-providers.php' => config_path('review-providers.php'),
        ], 'reviews-config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/review-providers.php',
            'reviews-providers'
        );


        $this->app->singleton('reviews', function () {
            return new Reviews(config('review-providers'));
        });
    }
}
