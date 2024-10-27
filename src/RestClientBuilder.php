<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway;

use Psr\Http\Client\ClientInterface as PsrHttpClient;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\Base64DecodingReadableStreamNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\BigDecimalNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\CountryIsoNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DateTimeUnixTimeNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DiscriminatorDefaultNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DriverLicenseNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DriverLicenseSeriesNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\EmailNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\InnNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\KppNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\PhoneNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianInternationalPassportNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianInternationalPassportSeriesNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianPassportDivisionCodeNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianPassportNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianPassportSeriesNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\SnilsNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\UidFailedNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\YearNormalizer;
use Vanta\Integration\EsiaGateway\Builder\CpgAuthorizationUrlBuilder;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\ConfigurationClient;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\HttpClient;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\AuthMiddleware;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\ClientErrorMiddleware;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\InternalServerMiddleware;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\Middleware;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\PipelineMiddleware;
use Vanta\Integration\EsiaGateway\Infrastructure\HttpClient\Middleware\UrlMiddleware;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\ScopeNormalizer;
use Vanta\Integration\EsiaGateway\Transport\RestEsiaGatewayClient;

final readonly class RestClientBuilder
{
    /**
     * @param non-empty-list<Middleware> $middlewares
     */
    private function __construct(
        private PsrHttpClient $client,
        public Serializer $serializer,
        private ConfigurationClient $configuration,
        private array $middlewares
    ) {
    }

    public static function create(PsrHttpClient $client, ConfigurationClient $configuration): self
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
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
            new YearNormalizer(),
            new BigDecimalNormalizer(),
            new DateTimeUnixTimeNormalizer(
                new DateTimeNormalizer([
                    DateTimeNormalizer::FORMAT_KEY => 'd.M.Y',
                ])
            ),
            new ScopeNormalizer(),
            new DiscriminatorDefaultNormalizer($objectNormalizer, $classMetadataFactory),
            new ArrayDenormalizer(),
        ];

        $middlewares = [
            new UrlMiddleware(),
            new AuthMiddleware(),
            new ClientErrorMiddleware(),
            new InternalServerMiddleware(),
        ];

        return new self(
            $client,
            new SymfonySerializer($normalizers, [new JsonEncoder()]),
            $configuration,
            $middlewares
        );
    }

    public function addMiddleware(Middleware $middleware): self
    {
        return new self(
            client: $this->client,
            serializer: $this->serializer,
            configuration: $this->configuration,
            middlewares: array_merge($this->middlewares, [$middleware])
        );
    }

    /**
     * @param non-empty-list<Middleware> $middlewares
     */
    public function withMiddlewares(array $middlewares): self
    {
        return new self(
            client: $this->client,
            serializer: $this->serializer,
            configuration: $this->configuration,
            middlewares: $middlewares
        );
    }

    public function withSerializer(Serializer $serializer): self
    {
        return new self(
            client: $this->client,
            serializer: $serializer,
            configuration: $this->configuration,
            middlewares: $this->middlewares
        );
    }

    public function withClient(PsrHttpClient $client): self
    {
        return new self(
            client: $client,
            serializer: $this->serializer,
            configuration: $this->configuration,
            middlewares: $this->middlewares
        );
    }

    /**
     * @param non-empty-string|null $redirectUri
     */
    public function createAuthorizationUrlBuilder(?string $redirectUri = null): CpgAuthorizationUrlBuilder
    {
        return new CpgAuthorizationUrlBuilder(
            $this->configuration->url,
            $this->configuration->clientId,
            $redirectUri ?? $this->configuration->redirectUri,
        );
    }

    /**
     * @param non-empty-string|null $redirectUri
     */
    public function createEsiaGatewayClient(?string $redirectUri = null): EsiaGatewayClient
    {
        return new RestEsiaGatewayClient(
            $this->serializer,
            new HttpClient(
                $this->configuration->withRedirectUri($redirectUri ?? $this->configuration->redirectUri),
                new PipelineMiddleware($this->middlewares, $this->client),
            ),
        );
    }
}
