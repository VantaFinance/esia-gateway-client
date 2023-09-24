<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer;

use Brick\PhoneNumber\PhoneNumber;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;
use Vanta\Integration\EsiaGateway\Model\Gender;

final class GenderNormalizer implements Denormalizer, Normalizer
{
    /**
     * @param string                    $data
     * @param class-string<PhoneNumber> $type
     * @param array<string>             $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): Gender
    {
        try {
            return new Gender($data);
        } catch (\UnexpectedValueException $e) {
            throw new UnexpectedValueException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param array<string, string> $context
     */
    public function supportsDenormalization($data, ?string $type = null, ?string $format = null, array $context = []): bool
    {
        return Gender::class === $type && is_string($data);
    }

    /**
     * @param Gender        $object
     * @param array<string> $context
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        return $object->getValue();
    }

    /**
     * @param array<string, string> $context
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Gender;
    }
}
