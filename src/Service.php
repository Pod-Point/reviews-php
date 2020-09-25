<?php

namespace PodPoint\Reviews;

interface Service
{
    /**
     * Sends an invite to review an order.
     *
     * @param string $email
     * @param string $name
     * @param string $order
     *
     * @return void
     */
    public function sendOrderReviewInvite(string $email, string $name, string $order): void;

    /**
     * Get review(s) between dates.
     *
     * @param string|null $from
     * @param string|null $to
     *
     * @return array|null
     */
    public function getCompanyReviewsBetweenDates(string $from = null, string $to = null): ?array;

    /**
     * Get review(s) for an order.
     *
     * @param string|null $orderId
     *
     * @return array|null
     */
    public function getOrderReview(string $orderId): ?array;
}
