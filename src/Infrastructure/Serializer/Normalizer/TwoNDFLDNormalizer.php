<?php
/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer;

use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Vanta\Integration\EsiaGateway\Struct\TwoNDFL;

final class TwoNDFLDNormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    private const SUPPORTED = 'vanta.esia.2ndfl';

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = [])
    {
        if (!is_array($data)) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                'Allowed type: array',
                $data,
                [Type::BUILTIN_TYPE_ARRAY],
                $context['deserialization_path'] ?? null,
                true
            );
        }

        if (array_key_exists('Документ', $data) && array_key_exists('СвНП', $data['Документ'])) {
            $data['Документ']['СвНА'] = $data['Документ']['СвНП'];

            unset($data['Документ']['СвНП']);
        }

        if (array_key_exists('Документ', $data) && array_key_exists('НДФЛ-2', $data['Документ'])) {
            $data['Документ']['СправДох'] = $data['Документ']['НДФЛ-2'];

            unset($data['Документ']['НДФЛ-2']);
        }

        return $this->denormalizer->denormalize($data, $type, $format, [...$context, self::SUPPORTED => true]);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return TwoNDFL::class == $type && !array_key_exists(self::SUPPORTED, $context);
    }
}
