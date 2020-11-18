<?php

namespace PodPoint\Reviews;

/**
 * Interface ActionsInterface.
 */
interface ActionsInterface
{
    /**
     * Send out review invite.
     *
     * @param array $options
     *
     * @return mixed
     */
    public function invite(array $options);

    /**
     * Get reviews.
     *
     * @param array $options
     *
     * @return mixed
     */
    public function getReviews(array $options = []);

    /**
     * Find reviews by id.
     *
     * @param string $reviewId
     *
     * @return mixed
     */
    public function findReview(array $options);
}
