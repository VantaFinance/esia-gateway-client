<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Psr\Http\Client\ClientExceptionInterface as ClientException;
use Vanta\Integration\EsiaGateway\Struct\UserInfo;

interface EsiaGatewayClient
{
    public function createAuthorizationUrlBuilder(): AuthorizationUrlBuilder;

    /**
     * @param non-empty-string  $code
     * @param ?non-empty-string $redirectUri
     *
     * @throws ClientException
     */
    public function getPairKeyByAuthorizationCode(string $code, ?string $redirectUri = null): PairKey;

    /**
     * @param non-empty-string  $refreshToken
     * @param ?non-empty-string $redirectUri
     *
     * @throws ClientException
     */
    public function getPairByRefreshToken(string $refreshToken, ?string $redirectUri = null): PairKey;

    /**
     * @param non-empty-string $accessToken
     *
     * @throws ClientException
     */
    public function getUserInfo(string $accessToken): UserInfo;
}
