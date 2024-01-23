<?php

/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\NameConverter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface as NameConverter;

final class NullNameConverter implements NameConverter
{
    public function normalize(string $propertyName): string
    {
        return $propertyName;
    }

    public function denormalize(string $propertyName): string
    {
        return $propertyName;
    }
}
