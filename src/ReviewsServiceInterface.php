<?php

namespace PodPoint\Reviews;

/**
 * Interface ReviewsServiceInterface
 * @package PodPoint\Reviews
 */
interface ReviewsServiceInterface
{
    /**
     * @return ActionsInterface
     */
    public function product(): ActionsInterface;

    /**
     * @return ActionsInterface
     */
    public function service(): ActionsInterface;
}
