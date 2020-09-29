<?php


namespace PodPoint\Reviews\Providers\Trustpilot\Request;


use PodPoint\Reviews\Providers\Trustpilot\AbstractTrustpilotApiClient;

class ServiceInviteRequest extends AbstractTrustpilotApiClient
{

    public function getEndpoint()
    {
        return 'https://invitations-api.trustpilot.com';
    }

    public function send()
    {
        $route = '/v1/private/business-units/{businessUnitId}/email-invitations';

        // TODO: Implement send() method.
    }
}
