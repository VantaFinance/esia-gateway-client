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
use InvalidArgumentException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as HttpClient;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\ConfigurationClient;
use Vanta\Integration\EsiaGateway\Struct\UserInfo;

final class DefaultEsiaGatewayClient implements EsiaGatewayClient
{
    private Serializer $serializer;

    private HttpClient $client;

    private ConfigurationClient $configuration;

    public function __construct(Serializer $serializer, HttpClient $client, ConfigurationClient $configuration)
    {
        $this->serializer    = $serializer;
        $this->client        = $client;
        $this->configuration = $configuration;
    }

    public function createAuthorizationUrlBuilder(): AuthorizationUrlBuilder
    {
        return new AuthorizationUrlBuilder(
            $this->configuration->getUrl(),
            $this->configuration->getClientId(),
            $this->configuration->getRedirectUri(),
        );
    }

    public function getAccessTokenByAuthorizationCode(string $code): AccessToken
    {
        $queryParams = http_build_query([
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $this->configuration->getRedirectUri(),
            'client_id'     => $this->configuration->getClientId(),
            'code'          => $code,
            'client_secret' => $this->configuration->getClientSecret(),
        ]);

        $request = new Request(
            SymfonyRequest::METHOD_POST,
            sprintf('/auth/token?%s', $queryParams),
        );

        $response = $this->client->sendRequest($request);

        return $this->serializer->deserialize($response->getBody()->__toString(), AccessToken::class, 'json');
    }

    public function getAccessTokenByRefreshToken(AccessToken|string $refreshToken): AccessToken
    {
        if ($refreshToken instanceof AccessToken) {
            $refreshToken = $refreshToken->getRefreshToken();
        }

        $queryParams = http_build_query([
            'grant_type'    => 'refresh_token',
            'redirect_uri'  => $this->configuration->getRedirectUri(),
            'client_id'     => $this->configuration->getClientId(),
            'refresh_token' => $refreshToken,
            'client_secret' => $this->configuration->getClientSecret(),
        ]);

        $request = new Request(
            SymfonyRequest::METHOD_POST,
            sprintf('/auth/token?%s', $queryParams),
        );

        $response = $this->client->sendRequest($request);

        return $this->serializer->deserialize($response->getBody()->__toString(), AccessToken::class, 'json');
    }

    /**
     * @psalm-suppress MixedInferredReturnType, MixedReturnStatement, MixedArgumentTypeCoercion, MixedArrayOffset, UndefinedConstant,
     *
     * @throws ClientExceptionInterface
     */
    public function getUserInfo(AccessToken|string $accessToken): UserInfo
    {
        if ($accessToken instanceof AccessToken) {
            $accessToken = $accessToken->getAccessToken();
        }

        $request = new Request(
            SymfonyRequest::METHOD_POST,
            '/auth/userinfo',
            [
                'Authorization' => sprintf('Bearer %s', $accessToken),
            ],
        );

        $response = $this->client->sendRequest($request);
        $contents = $response->getBody()->__toString();

        return $this->serializer->deserialize($contents, UserInfo::class, 'json', [
            UnwrappingDenormalizer::UNWRAP_PATH => '[info]',
        ]);
    }
}
