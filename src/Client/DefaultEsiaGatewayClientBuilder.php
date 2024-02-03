<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Doctrine\Common\Annotations\AnnotationReader;
use Psr\Http\Client\ClientInterface as PsrHttpClient;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\ConfigurationClient;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\HttpClient;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\ClientErrorMiddleware;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\InternalServerMiddleware;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\Middleware;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\PipelineMiddleware;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\UrlMiddleware;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\Base64DecodingReadableStreamNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\BigDecimalNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\CountryIsoNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\DateTimeUnixTimeNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\DiscriminatorDefaultNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\DriverLicenseNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\DriverLicenseSeriesNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\EmailNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\InnNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\KppNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\PhoneNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\RussianInternationalPassportNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\RussianInternationalPassportSeriesNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\RussianPassportDivisionCodeNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\RussianPassportNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\RussianPassportSeriesNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\ScopeNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\SnilsNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\UidFailedNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\YearNormalizer;

final class DefaultEsiaGatewayClientBuilder
{
    public readonly Serializer $serializer;

    private readonly PsrHttpClient $client;

    /**
     * @var non-empty-string
     */
    private readonly string $clientId;

    /**
     * @var non-empty-string
     */
    private readonly string $clientSecret;

    /**
     * @var list<Middleware>
     */
    private readonly array $middlewares;

    /**
     * @param list<Middleware> $middlewares
     * @param non-empty-string $clientId
     * @param non-empty-string $clientSecret
     */
    private function __construct(PsrHttpClient $client, Serializer $serializer, string $clientId, string $clientSecret, array $middlewares)
    {
        $this->client       = $client;
        $this->serializer   = $serializer;
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->middlewares  = $middlewares;
    }

    /**
     * @param non-empty-string $clientId
     * @param non-empty-string $clientSecret
     */
    public static function create(PsrHttpClient $client, string $clientId, string $clientSecret): self
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $objectNormalizer     = new ObjectNormalizer(
            $classMetadataFactory,
            new MetadataAwareNameConverter($classMetadataFactory),
            null,
            new PropertyInfoExtractor(
                [],
                [new PhpStanExtractor()],
                [],
                [],
                []
            ),
            new ClassDiscriminatorFromClassMetadata($classMetadataFactory),
        );

        $normalizers = [
            new UnwrappingDenormalizer(),
            new BackedEnumNormalizer(),
            new UidFailedNormalizer(new UidNormalizer()),
            new Base64DecodingReadableStreamNormalizer(),
            new RussianPassportNumberNormalizer(),
            new RussianPassportSeriesNormalizer(),
            new RussianPassportDivisionCodeNormalizer(),
            new RussianInternationalPassportNumberNormalizer(),
            new RussianInternationalPassportSeriesNormalizer(),
            new DriverLicenseNumberNormalizer(),
            new DriverLicenseSeriesNormalizer(),
            new InnNumberNormalizer(),
            new SnilsNumberNormalizer(),
            new KppNumberNormalizer(),
            new CountryIsoNormalizer(),
            new PhoneNumberNormalizer(),
            new EmailNormalizer(),
            new ScopeNormalizer(),
            new YearNormalizer(),
            new BigDecimalNormalizer(),
            new DateTimeUnixTimeNormalizer(
                new DateTimeNormalizer([
                    DateTimeNormalizer::FORMAT_KEY => 'd.M.Y',
                ])
            ),
            new DiscriminatorDefaultNormalizer($classMetadataFactory, $objectNormalizer),
            $objectNormalizer,
            new ArrayDenormalizer(),
        ];

        $middlewares = [
            new UrlMiddleware(),
            new ClientErrorMiddleware(),
            new InternalServerMiddleware(),
        ];

        return new self(
            $client,
            new SymfonySerializer($normalizers, [new JsonEncoder()]),
            $clientId,
            $clientSecret,
            $middlewares
        );
    }

    public function addMiddleware(Middleware $middleware): self
    {
        return new self(
            $this->client,
            $this->serializer,
            $this->clientId,
            $this->clientSecret,
            array_merge($this->middlewares, [$middleware])
        );
    }

    /**
     * @param non-empty-list<Middleware> $middlewares
     */
    public function withMiddlewares(array $middlewares): self
    {
        return new self(
            $this->client,
            $this->serializer,
            $this->clientId,
            $this->clientSecret,
            $middlewares
        );
    }

    public function withSerializer(Serializer $serializer): self
    {
        return new self(
            $this->client,
            $serializer,
            $this->clientId,
            $this->clientSecret,
            $this->middlewares
        );
    }

    public function withClient(PsrHttpClient $client): self
    {
        return new self(
            $client,
            $this->serializer,
            $this->clientId,
            $this->clientSecret,
            $this->middlewares
        );
    }

    /**
     * @param non-empty-string $url
     * @param non-empty-string $redirectUri
     */
    public function createEsiaGatewayClient(string $url, string $redirectUri): EsiaGatewayClient
    {
        $configuration = new ConfigurationClient($this->clientId, $this->clientSecret, $url, $redirectUri);

        return new DefaultEsiaGatewayClient(
            $this->serializer,
            new HttpClient(
                $configuration,
                new PipelineMiddleware($this->middlewares, $this->client),
            ),
            $configuration,
        );
    }
}
