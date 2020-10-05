<?php

namespace PodPoint\Reviews;

/**
 * Interface ActionsInterface
 * @package PodPoint\Reviews
 */
interface ActionsInterface
{
    public function invite(array $options);
    public function fetchAll(array $options);
    public function find(string $reference);
}
