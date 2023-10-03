<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use Doctrine\Common\Annotations\AnnotationReader;
use Psr\Http\Client\ClientInterface as PsrHttpClient;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
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
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\CountryIsoNormalizer;
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

final class DefaultEsiaGatewayClientBuilder
{
    private PsrHttpClient $client;

    private Serializer $serializer;

    /**
     * @var non-empty-string
     */
    private string $clientId;

    /**
     * @var non-empty-string
     */
    private string $clientSecret;

    /**
     * @var non-empty-list<Middleware>
     */
    private array $middlewares;

    /**
     * @param list<Middleware> $middlewares
     * @param non-empty-string       $clientId
     * @param non-empty-string       $clientSecret
     */
    private function __construct(PsrHttpClient $client, Serializer $serializer, string $clientId, string $clientSecret, array $middlewares = [])
    {
        $this->client       = $client;
        $this->serializer   = $serializer;
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->middlewares  = array_merge($middlewares, [
            new UrlMiddleware(),
            new ClientErrorMiddleware(),
            new InternalServerMiddleware(),
        ]);
    }

    /**
     * @psalm-suppress MixedArgumentTypeCoercion, TooManyArguments, UndefinedClass, MissingDependency, InvalidArgument
     *
     * @param non-empty-string $clientId
     * @param non-empty-string $clientSecret
     */
    public static function create(PsrHttpClient $client, string $clientId, string $clientSecret): self
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $reflectionExtractor = new ReflectionExtractor();
        $phpDocExtractor = new PhpDocExtractor();
        $propertyTypeExtractor = new PropertyInfoExtractor([$reflectionExtractor], [$phpDocExtractor, $reflectionExtractor], [$phpDocExtractor], [$reflectionExtractor], [$reflectionExtractor]);

        $normalizers = [
            new UnwrappingDenormalizer(),
            new BackedEnumNormalizer(),
            new UidNormalizer(),
            new RussianPassportNumberNormalizer(),
            new RussianPassportSeriesNormalizer(),
            new RussianPassportDivisionCodeNormalizer(),
            new RussianInternationalPassportNumberNormalizer(),
            new RussianInternationalPassportSeriesNormalizer(),
            new InnNumberNormalizer(),
            new SnilsNumberNormalizer(),
            new KppNumberNormalizer(),
            new CountryIsoNormalizer(),
            new PhoneNumberNormalizer(),
            new EmailNormalizer(),
            new ScopeNormalizer(),
            new DateTimeNormalizer([
                DateTimeNormalizer::FORMAT_KEY => 'd.M.Y',
            ]),
            new ObjectNormalizer(
                $classMetadataFactory,
                new MetadataAwareNameConverter($classMetadataFactory),
                null,
                $propertyTypeExtractor,
                new ClassDiscriminatorFromClassMetadata($classMetadataFactory),
            ),
            new ArrayDenormalizer(),
        ];

        $encoders = [
            new JsonEncoder(),
        ];

        $serializer = new SymfonySerializer($normalizers, $encoders);

        return new self($client, $serializer, $clientId, $clientSecret);
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
        return new self($this->client, $serializer, $this->clientId, $this->clientSecret);
    }

    public function withClient(PsrHttpClient $client): self
    {
        return new self($client, $this->serializer, $this->clientId, $this->clientSecret);
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
