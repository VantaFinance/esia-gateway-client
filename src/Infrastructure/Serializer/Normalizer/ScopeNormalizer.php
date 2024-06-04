<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer;

use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Vanta\Integration\Esia\Struct\Permission;

final readonly class ScopeNormalizer implements Denormalizer
{
    public function getSupportedTypes(?string $format): array
    {
        return [
            Permission::class . '[]' => true,
        ];
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return Permission::class . '[]' == $type;
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array{deserialization_path?: non-empty-string} $context
     *
     * @return array<Permission>
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): array
    {
        if (is_string($data)) {
            return array_map(Permission::from(...), explode(' ', $data));
        }

        if (is_array($data)) {
            return array_map(Permission::from(...), $data);
        }

        throw NotNormalizableValueException::createForUnexpectedDataType(
            sprintf('Ожидали массив строк/строку, получили: %s', get_debug_type($data)),
            $data,
            [Type::BUILTIN_TYPE_STRING, Type::BUILTIN_TYPE_ARRAY],
            $context['deserialization_path'] ?? null,
            true
        );
    }
}
