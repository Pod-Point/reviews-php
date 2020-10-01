<?php

namespace PodPoint\Reviews\Tests;

use PodPoint\Reviews\AccessToken;

/**
 * Class AccessTokenTest
 * @package PodPoint\Reviews\Tests
 */
class AccessTokenTest extends TestCase
{
    /**
     * Access token constructor should set properties.
     */
    public function testConstruct()
    {
        $token = [
            'access_token' => 'ey12easdwrsyeud6if7gohoji8hp97o68fi',
            'expires_in' => '3600',
            'refresh_token' => '0/koiouliykgutjyhethrfjyguktrdyfS3'
        ];

        $accessToken = new AccessToken($token);

        $this->assertEquals('ey12easdwrsyeud6if7gohoji8hp97o68fi', $accessToken->accessToken);
        $this->assertEquals('3600', $accessToken->expiresIn);
        $this->assertEquals('0/koiouliykgutjyhethrfjyguktrdyfS3', $accessToken->refreshToken);
    }
}
