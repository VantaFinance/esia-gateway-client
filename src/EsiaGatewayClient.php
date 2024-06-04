<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway;

use Psr\Http\Client\ClientExceptionInterface as ClientException;
use Vanta\Integration\EsiaGateway\Response\PairKey;
use Vanta\Integration\EsiaGateway\Response\UserInfo;

interface EsiaGatewayClient
{
    /**
     * @param non-empty-string      $code
     * @param non-empty-string|null $redirectUri
     *
     * @throws ClientException
     */
    public function getPairKeyByAuthorizationCode(string $code, ?string $redirectUri = null): PairKey;

    /**
     * @param non-empty-string      $refreshToken
     * @param non-empty-string|null $redirectUri
     *
     * @throws ClientException
     */
    public function getPairKeyByRefreshToken(string $refreshToken, ?string $redirectUri = null): PairKey;

    /**
     * @param non-empty-string $accessToken
     *
     * @throws ClientException
     */
    public function getUserInfo(string $accessToken): UserInfo;
}
