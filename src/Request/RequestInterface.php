<?php


namespace PodPoint\Reviews\Request;


interface RequestInterface
{
    /**
     * @return bool
     */
    public function validate(): bool;
}
