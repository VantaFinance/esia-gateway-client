<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Vanta\Integration\EsiaGateway\Model\UserInfo;

interface EsiaGatewayClient
{
    public function createAuthorizationUrlBuilder(string $redirectUri): AuthorizationUrlBuilder;

    public function getAccessTokenByAuthorizationCode(string $code, string $redirectUri): AccessToken;

    /**
     * @param string|AccessToken $refreshToken
     *
     * @return AccessToken
     */
    public function getAccessTokenByRefreshToken($refreshToken, string $redirectUri): AccessToken;

    /**
     * @param string|AccessToken $accessToken
     *
     * @return UserInfo
     */
    public function getUserInfo($accessToken): UserInfo;
}
