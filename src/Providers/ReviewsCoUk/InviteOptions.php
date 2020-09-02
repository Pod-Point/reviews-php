<?php

namespace PodPoint\Reviews\Providers\ReviewsCoUk;

class InviteOptions
{
    /**
     * Name of the customer you would like to send the invite to.
     *
     * @var string
     */
    public string $name;

    /**
     * The email you would like to send the invite to.
     *
     * @var string
     */
    public string $email;

    /**
     * The order number for which you would like to send an invite.
     *
     * @var string
     */
    public string $orderNumber;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->name = $options['name'];
        $this->email = $options['email'];
        $this->orderNumber = $options['orderNumber'];
    }
}
