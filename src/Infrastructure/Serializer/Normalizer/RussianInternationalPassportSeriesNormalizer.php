<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer;

use InvalidArgumentException;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;
use Vanta\Integration\EsiaGateway\Struct\RussianInternationalPassportSeries;
use Webmozart\Assert\Assert;

final class RussianInternationalPassportSeriesNormalizer implements Normalizer, Denormalizer
{
    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return RussianInternationalPassportSeries::class == $type;
    }

    public function denormalize($data, string $type, ?string $format = null, array $context = []): RussianInternationalPassportSeries
    {
        try {
            Assert::string($data);

            return new RussianInternationalPassportSeries($data);
        } catch (InvalidArgumentException $e) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                $e->getMessage(),
                $data,
                [Type::BUILTIN_TYPE_INT, Type::BUILTIN_TYPE_STRING],
                $context['deserialization_path'] ?? null,
                true
            );
        }
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof RussianInternationalPassportSeries;
    }

    /**
     * @return non-empty-string
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        if (!$object instanceof RussianInternationalPassportSeries || '' == $object->getValue()) {
            throw new UnexpectedValueException(sprintf('Allowed type: %s', RussianInternationalPassportSeries::class));
        }

        return $object->getValue();
    }
}
