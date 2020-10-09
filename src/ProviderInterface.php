<?php

namespace PodPoint\Reviews;

/**
 * Interface ProviderInterface
 * @package PodPoint\Reviews
 */
interface ProviderInterface
{
    /**
     * Returns product related actions, e.g invitation or reviews.
     *
     * @return ActionsInterface
     */
    public function product(): ActionsInterface;

    /**
     * Returns service/business/merchant related actions, e.g invitation or reviews.
     *
     * @return ActionsInterface
     */
    public function merchant(): ActionsInterface;
}
