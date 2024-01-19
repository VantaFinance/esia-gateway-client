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
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;
use Vanta\Integration\EsiaGateway\Client\Scope;
use Vanta\Integration\EsiaGateway\Client\ScopePermission;

final class ScopeNormalizer implements Normalizer, Denormalizer
{
    /**
     * @psalm-suppress MissingParamType
     *
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return Scope::class == $type;
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array{deserialization_path?: non-empty-string} $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): Scope
    {
        if (is_string($data)) {
            return Scope::fromRawScope($data);
        }

        if (is_array($data)) {
            return new Scope(array_map(ScopePermission::from(...), $data));
        }

        throw NotNormalizableValueException::createForUnexpectedDataType(
            sprintf('Ожидали массив строк/строку, получили: %s', get_debug_type($data)),
            $data,
            [Type::BUILTIN_TYPE_STRING, Type::BUILTIN_TYPE_ARRAY],
            $context['deserialization_path'] ?? null,
            true
        );
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array<string, mixed> $context
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Scope;
    }

    /**
     * @param object               $object
     * @param array<string, mixed> $context
     *
     * @return literal-string
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        if (!$object instanceof Scope) {
            throw new UnexpectedValueException(sprintf('Allowed type: %s', Scope::class));
        }

        return $object->__toString();
    }
}
