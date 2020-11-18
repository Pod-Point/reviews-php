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
     * Find reviews by review id.
     *
     * @param string $reviewId
     *
     * @return mixed
     */
    public function findReview(string $reviewId);

    /**
     * Find reviews by order number.
     *
     * @param string $orderNumber
     *
     * @return mixed
     */
    public function findReviewByOrderNumber(string $orderNumber);
}
