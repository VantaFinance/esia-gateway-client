<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface as ClassMetadataFactory;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface as NameConverter;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Throwable;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Attributes\DiscriminatorDefault;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\NameConverter\NullNameConverter;

final class DiscriminatorDefaultNormalizer implements Denormalizer
{
    public function __construct(
        private readonly ClassMetadataFactory $metadataFactory,
        private readonly ObjectNormalizer $objectNormalizer,
        private readonly NameConverter $nameConverter = new NullNameConverter(),
    ) {
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array{deserialization_path?: non-empty-string, key_type?: non-empty-string} $context
     *
     * @throws Throwable
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $mapping         = $this->metadataFactory->getMetadataFor($type);
        $reflectionClass = $mapping->getReflectionClass();
        $discriminator   = $mapping->getClassDiscriminatorMapping();

        if (null === $discriminator) {
            return $this->objectNormalizer->denormalize($data, $type, $format, $context);
        }

        $key       = $this->nameConverter->normalize($discriminator->getTypeProperty());
        $attribute = $reflectionClass->getAttributes(DiscriminatorDefault::class)[0] ?? null;
        $attribute = $attribute?->newInstance();

        if (array_key_exists($key, $data) && array_key_exists($data[$key], $discriminator->getTypesMapping())) {
            try {
                return $this->objectNormalizer->denormalize($data, $type, $format, $context);
            } catch (Throwable $e) {
                $context['esia_errors'][] = $e;

                if (array_key_exists('key_type', $context) && null != $attribute) {
                    return $this->objectNormalizer->denormalize($data, $attribute->class, $format, $context);
                }

                throw $e;
            }
        }

        if (null == $attribute) {
            return $this->objectNormalizer->denormalize($data, $type, $format, $context);
        }

        return $this->objectNormalizer->denormalize($data, $attribute->class, $format, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if (!$this->metadataFactory->hasMetadataFor($type)) {
            return false;
        }

        try {
            $metadata = $this->metadataFactory->getMetadataFor($type);
        } catch (InvalidArgumentException) {
            return false;
        }

        if (null == $metadata->getClassDiscriminatorMapping()) {
            return false;
        }

        return 0 != count($metadata->getReflectionClass()->getAttributes(DiscriminatorDefault::class));
    }
}
