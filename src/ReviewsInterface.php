<?php

namespace PodPoint\Reviews;

/**
 * Interface ProductReviewsInterface
 * @package PodPoint\Reviews
 */
interface ReviewsInterface
{
    public function invite();
    public function fetchAll();
    public function find(string $reference);
}
