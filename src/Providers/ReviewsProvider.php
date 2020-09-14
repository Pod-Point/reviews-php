<?php

namespace PodPoint\Reviews\Providers;

use Illuminate\Support\ServiceProvider;

class ReviewsProvider extends ServiceProvider
{
    /**
     * Create a new reviews.php config file for storing the details of the review providers like reviews.co.uk and in
     * the future Trust pilot.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/reviews.php' => config_path('reviews.php'),
        ]);
    }
}
