<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Vanta\Integration\EsiaGateway\Struct\UserInfo;

interface EsiaGatewayClient
{
    public function createAuthorizationUrlBuilder(): AuthorizationUrlBuilder;

    public function getAccessTokenByAuthorizationCode(string $code): AccessToken;

    public function getAccessTokenByRefreshToken(AccessToken|string $refreshToken): AccessToken;

    public function getUserInfo(AccessToken|string $accessToken): UserInfo;
}
