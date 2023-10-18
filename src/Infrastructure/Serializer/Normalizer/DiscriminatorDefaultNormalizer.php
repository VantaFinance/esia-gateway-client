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
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Attributes\DiscriminatorDefault;

final class DiscriminatorDefaultNormalizer implements Denormalizer
{
    public function __construct(
        private readonly ClassMetadataFactory $metadataFactory,
        private readonly ObjectNormalizer $objectNormalizer,
        private readonly ?NameConverter $nameConverter = null,
    ) {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []):mixed
    {
        $mapping = $this->metadataFactory->getMetadataFor($type);
        $reflectionClass = $mapping->getReflectionClass();
        $discriminator = $mapping->getClassDiscriminatorMapping();
        if ($discriminator === null) {
            return $this->objectNormalizer->denormalize($data, $type, $format, $context);
        }

        if ($this->nameConverter) {
            $key = $this->nameConverter->normalize($discriminator->getTypeProperty());
        } else {
            $key = $discriminator->getTypeProperty();
        }

        if (array_key_exists($key, $data) && array_key_exists($data[$key], $discriminator->getTypesMapping())) {
            return $this->objectNormalizer->denormalize($data, $type, $format, $context);
        }

        $attributes = $reflectionClass->getAttributes(DiscriminatorDefault::class);
        /** @var DiscriminatorDefault $default */
        $default = array_pop($attributes)->newInstance();

        return $this->objectNormalizer->denormalize($data, $default->class, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        try {
            if (!$this->metadataFactory->hasMetadataFor($type)) {
                return false;
            }

            if (!$this->metadataFactory->getMetadataFor($type)->getClassDiscriminatorMapping()) {
                return false;
            }

            return $this->hasDefaultAttribute($type);
        } catch (InvalidArgumentException) {
            return false;
        }
    }

    private function hasDefaultAttribute(string $class):bool
    {
        $reflectionClass =  $this->metadataFactory->getMetadataFor($class)->getReflectionClass();
        $attributes = $reflectionClass->getAttributes(DiscriminatorDefault::class);

        return 0 != count($attributes);
    }
}
