<?php

namespace PodPoint\Reviews;

/**
 * Interface ActionsInterface
 * @package PodPoint\Reviews
 */
interface ActionsInterface
{
    /**
     * @param array $options
     * @return mixed
     */
    public function invite(array $options);

    /**
     * @param array $options
     * @return mixed
     */
    public function getReviews(array $options);

    /**
     * @param string $reviewId
     * @return mixed
     */
    public function findReview(string $reviewId);
}
