<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Vanta\Integration\EsiaGateway\Struct\UserInfo;

interface EsiaGatewayClient
{
    public function createAuthorizationUrlBuilder(): AuthorizationUrlBuilder;

    public function getAccessTokenByAuthorizationCode(string $code): AccessToken;

    /**
     * @param string|AccessToken $refreshToken
     *
     * @return AccessToken
     */
    public function getAccessTokenByRefreshToken($refreshToken): AccessToken;

    /**
     * @param string|AccessToken $accessToken
     *
     * @return UserInfo
     */
    public function getUserInfo($accessToken): UserInfo;
}
