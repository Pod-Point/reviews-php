<?php

namespace PodPoint\ReviewsLaravel;

use PodPoint\Reviews\Manager;

/**
 * Class ServiceProvider
 * @package PodPoint\ReviewsLaravel
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/review-providers.php' => config_path('reviews-providers.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/reviews-providers.php', 'reviews-providers'
        );

        $this->app->singleton(Manager::class, function() {
            return new Manager(config('reviews-providers'));
        });
    }
}
