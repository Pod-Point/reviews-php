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
}
