<?php

/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer;

use DateTimeInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface as CacheableSupportsMethod;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;

/**
 * @method array getSupportedTypes(?string $format)
 */
final class DateTimeUnixTimeNormalizer implements Normalizer, Denormalizer, CacheableSupportsMethod
{
    private const SUPPORTED = 'vanta.esia.date_time_unix_time';

    public function __construct(
        private readonly DateTimeNormalizer $normalizer,
    ) {
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return $this->normalizer->hasCacheableSupportsMethod();
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): DateTimeInterface
    {
        if (\is_int($data) || \is_float($data)) {
            switch ($context[DateTimeNormalizer::FORMAT_KEY]  ?? null) {
                case 'U': $data = sprintf('%d', $data); break;
                case 'U.u': $data = sprintf('%.6F', $data); break;
            }
        }

        return $this->normalizer->denormalize($data, $type, $format, [...$context, self::SUPPORTED => true]);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $this->normalizer->supportsDenormalization($data, $type, $format) && !array_key_exists(self::SUPPORTED, $context);
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): string
    {
        return $this->normalizer->normalize($object, $format, [...$context, self::SUPPORTED => true]);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $this->normalizer->supportsNormalization($data, $format) && !array_key_exists(self::SUPPORTED, $context);
    }
}
