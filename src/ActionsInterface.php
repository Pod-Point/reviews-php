<?php

namespace PodPoint\Reviews;

/**
 * Interface ActionsInterface
 * @package PodPoint\Reviews
 */
interface ActionsInterface
{
    public function invite(array $options);
    public function getReviews(array $options);
    public function findReview(string $reviewId);
}
