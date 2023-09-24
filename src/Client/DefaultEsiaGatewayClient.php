<?php

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
use Vanta\Integration\EsiaGateway\Model\UserInfo;

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

    public function createAuthorizationUrlBuilder(string $redirectUri): AuthorizationUrlBuilder
    {
        return new AuthorizationUrlBuilder(
            $this->configuration->getUrl(),
            $this->configuration->getClientId(),
            $redirectUri,
        );
    }

    public function getAccessTokenByAuthorizationCode(string $code, string $redirectUri): AccessToken
    {
        $queryParams = http_build_query([
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $redirectUri,
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

    public function getAccessTokenByRefreshToken($refreshToken, string $redirectUri): AccessToken
    {
        if ($refreshToken instanceof AccessToken) {
            $refreshToken = $refreshToken->getRefreshToken();
        }

        if (!is_string($refreshToken)) {
            throw new InvalidArgumentException('Argument `$refreshToken` must be a string or an instance of ' . AccessToken::class);
        }

        $queryParams = http_build_query([
            'grant_type'    => 'refresh_token',
            'redirect_uri'  => $redirectUri,
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
    public function getUserInfo($accessToken): UserInfo
    {
        if ($accessToken instanceof AccessToken) {
            $accessToken = $accessToken->getAccessToken();
        }

        if (!is_string($accessToken)) {
            throw new InvalidArgumentException('Argument `$accessToken` must be a string or an instance of ' . AccessToken::class);
        }

        $request = new Request(
            SymfonyRequest::METHOD_POST,
            '/auth/userinfo',
            [
                'Authorization' => sprintf('Bearer %s', $accessToken),
            ],
        );

        $response = $this->client->sendRequest($request);

        return $this->serializer->deserialize($response->getBody()->__toString(), UserInfo::class, 'json', [
            UnwrappingDenormalizer::UNWRAP_PATH => '[info]',
        ]);
    }
}
