<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Vanta\Integration\EsiaGateway\Struct\UserInfo;

interface EsiaGatewayClient
{
    public function createAuthorizationUrlBuilder(): AuthorizationUrlBuilder;

    /**
     * @param ?non-empty-string $redirectUri
     */
    public function getAccessTokenByAuthorizationCode(string $code, ?string $redirectUri = null): AccessToken;

    /**
     * @param ?non-empty-string $redirectUri
     */
    public function getAccessTokenByRefreshToken(AccessToken|string $refreshToken, ?string $redirectUri = null): AccessToken;

    public function getUserInfo(AccessToken|string $accessToken): UserInfo;
}
