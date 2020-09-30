<?php

namespace PodPoint\Reviews;

/**
 * Interface ProductReviewsInterface
 * @package PodPoint\Reviews
 */
interface ReviewsInterface
{
    public function invite(array $options);
    public function fetchAll(array $options);
    public function find(string $reference);
}
