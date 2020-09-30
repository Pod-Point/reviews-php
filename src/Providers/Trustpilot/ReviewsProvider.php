<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ReviewsInterface;
use PodPoint\Reviews\ReviewsServiceInterface;

class ReviewsProvider implements ReviewsServiceInterface
{
    /**
     * @return ReviewsInterface
     */
    public function product(): ReviewsInterface
    {
        return new ProductReview();
    }

    /**
     * @return ReviewsInterface
     */
    public function service(): ReviewsInterface
    {
        return new ServiceReview();
    }
}
