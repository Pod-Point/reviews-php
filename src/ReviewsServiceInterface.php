<?php

namespace PodPoint\Reviews;

/**
 * Interface ReviewsServiceInterface
 * @package PodPoint\Reviews
 */
interface ReviewsServiceInterface
{

    /**
     * @return ReviewsInterface
     */
    public function product(): ReviewsInterface;

    /**
     * @return ReviewsInterface
     */
    public function service(): ReviewsInterface;
}
