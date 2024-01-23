<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface as HttpClient;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer as Normalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\ConfigurationClient;
use Vanta\Integration\EsiaGateway\Struct\UserInfo;
use Yiisoft\Http\Method;

final class DefaultEsiaGatewayClient implements EsiaGatewayClient
{
    public function __construct(
        private readonly Serializer $serializer,
        private readonly HttpClient $client,
        private readonly ConfigurationClient $configuration
    ) {
    }

    public function createAuthorizationUrlBuilder(): AuthorizationUrlBuilder
    {
        return new AuthorizationUrlBuilder(
            $this->configuration->url,
            $this->configuration->clientId,
            $this->configuration->redirectUri,
        );
    }

    public function getPairKeyByAuthorizationCode(string $code, ?string $redirectUri = null): PairKey
    {
        $queryParams = http_build_query([
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'client_id'     => $this->configuration->clientId,
            'client_secret' => $this->configuration->clientSecret,
            'redirect_uri'  => $redirectUri ?? $this->configuration->redirectUri,
        ]);

        $request = new Request(Method::POST, sprintf('/auth/token?%s', $queryParams));
        $content = $this->client->sendRequest($request)->getBody()->__toString();

        return $this->serializer->deserialize($content, PairKey::class, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'U',
        ]);
    }

    public function getPairKeyByRefreshToken(string $refreshToken, ?string $redirectUri = null): PairKey
    {
        $queryParams = http_build_query([
            'refresh_token' => $refreshToken,
            'grant_type'    => 'refresh_token',
            'client_id'     => $this->configuration->clientId,
            'client_secret' => $this->configuration->clientSecret,
            'redirect_uri'  => $redirectUri ?? $this->configuration->redirectUri,
        ]);

        $request = new Request(Method::POST, sprintf('/auth/token?%s', $queryParams));
        $content = $this->client->sendRequest($request)->getBody()->__toString();

        return $this->serializer->deserialize($content, PairKey::class, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'U',
        ]);
    }

    public function getUserInfo(string $accessToken): UserInfo
    {
        $request = new Request(
            Method::POST,
            '/auth/userinfo',
            ['Authorization' => sprintf('Bearer %s', $accessToken)],
        );

        $content = $this->client->sendRequest($request)->getBody()->__toString();

        return $this->serializer->deserialize($content, UserInfo::class, 'json', [
            UnwrappingDenormalizer::UNWRAP_PATH       => '[info]',
            Normalizer::DEFAULT_CONSTRUCTOR_ARGUMENTS => [UserInfo::class => ['rawInfo' => $content]],
        ]);
    }
}
