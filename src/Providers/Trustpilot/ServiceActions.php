<?php

namespace PodPoint\Reviews\Providers\Trustpilot;

use PodPoint\Reviews\ApiClientInterface;
use PodPoint\Reviews\Exceptions\ValidationException;
use PodPoint\Reviews\Providers\Trustpilot\Request\Service\InviteRequest;
use PodPoint\Reviews\Providers\Trustpilot\Request\Service\FetchAllRequest;
use PodPoint\Reviews\ActionsInterface;

/**
 * Class ServiceActions
 * @package PodPoint\Reviews\Providers\Trustpilot
 */
class ServiceActions implements ActionsInterface
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    /***
     * @var string
     */
    protected $businessUnitId;

    /**
     * ServiceActions constructor.
     * @param ApiClientInterface $apiClient
     */
    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param array $options
     * @return array|mixed
     * @throws ValidationException
     */
    public function invite(array $options)
    {
        $options['businessUnitId'] = $this->businessUnitId;
        $request = new InviteRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param array $options
     * @return array|mixed
     * @throws ValidationException
     */
    public function fetchAll(array $options)
    {
        $options['businessUnitId'] = $this->businessUnitId;
        $request = new FetchAllRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param string $reference
     * @return array|mixed
     */
    public function find(string $reference)
    {
        $options = [
            'referenceId' => $reference,
            'businessUnitId' => $this->businessUnitId,
        ];

        $request = new FetchAllRequest($this->apiClient, $options);

        return $request->send();
    }

    /**
     * @param $businessUnitId
     * @return $this
     */
    public function setBusinessUnitId(string $businessUnitId): ServiceActions
    {
        $this->businessUnitId = $businessUnitId;

        return $this;
    }

    /**
     * @return string
     */
    public function getBusinessUnitId()
    {
        return $this->businessUnitId;
    }
}
