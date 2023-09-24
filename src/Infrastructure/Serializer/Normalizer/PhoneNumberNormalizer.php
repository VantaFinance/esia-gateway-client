<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;

final class PhoneNumberNormalizer implements Denormalizer, Normalizer
{
    /**
     * @param string                    $data
     * @param class-string<PhoneNumber> $type
     * @param array<string>             $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): PhoneNumber
    {
        try {
            return PhoneNumber::parse($data);
        } catch (PhoneNumberException $e) {
            throw new UnexpectedValueException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param array<string, string> $context
     */
    public function supportsDenormalization($data, ?string $type = null, ?string $format = null, array $context = []): bool
    {
        return PhoneNumber::class === $type && is_string($data);
    }

    /**
     * @param PhoneNumber   $object
     * @param array<string> $context
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        return $object->jsonSerialize();
    }

    /**
     * @param array<string, string> $context
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof PhoneNumber;
    }
}
