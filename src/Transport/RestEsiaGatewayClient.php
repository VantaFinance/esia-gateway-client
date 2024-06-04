<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Transport;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Client\ClientInterface as HttpClient;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer as Normalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\Esia\Struct\GrantType;
use Vanta\Integration\EsiaGateway\EsiaGatewayClient;
use Vanta\Integration\EsiaGateway\Response\PairKey;
use Vanta\Integration\EsiaGateway\Response\UserInfo;
use Yiisoft\Http\Method;

final readonly class RestEsiaGatewayClient implements EsiaGatewayClient
{
    public function __construct(
        private Serializer $serializer,
        private HttpClient $client,
    ) {
    }

    public function getPairKeyByAuthorizationCode(string $code, ?string $redirectUri = null): PairKey
    {
        $query = http_build_query([
            'code'       => $code,
            'grant_type' => GrantType::AUTHORIZATION_CODE->value,
        ]);

        $request = new Request(Method::POST, sprintf('/auth/token?%s', $query), ['redirect_uri' => (string) $redirectUri]);
        $content = $this->client->sendRequest($request)->getBody()->__toString();

        return $this->serializer->deserialize($content, PairKey::class, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'U',
        ]);
    }

    public function getPairKeyByRefreshToken(string $refreshToken, ?string $redirectUri = null): PairKey
    {
        $query = http_build_query([
            'refresh_token' => $refreshToken,
            'grant_type'    => GrantType::REFRESH_TOKEN->value,
        ]);

        $request = new Request(Method::POST, sprintf('/auth/token?%s', $query), ['redirect_uri' => (string) $redirectUri]);
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

        $stream = Utils::streamFor(file_get_contents('esia_data_1.json'));

        return $this->serializer->deserialize($stream->__toString(), UserInfo::class, 'json', [
            UnwrappingDenormalizer::UNWRAP_PATH       => '[info]',
            Normalizer::DEFAULT_CONSTRUCTOR_ARGUMENTS => [UserInfo::class => ['rawInfo' => $stream]],
        ]);
    }
}
