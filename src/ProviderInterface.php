<?php

namespace PodPoint\Reviews;

/**
 * Interface ProviderInterface
 * @package PodPoint\Reviews
 */
interface ProviderInterface
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
