<?php

namespace PodPoint\Reviews;

interface Service
{
    /**
     * Creates an invite.
     *
     * @param array $options
     */
    public function invite(array $options);

    /**
     * Get review(s).
     *
     * @param array $options
     *
     * @return array|null
     */
    public function get(array $options);
}
