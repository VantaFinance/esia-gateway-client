<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class DiscriminatorDefault
{
    /**
     * @param class-string $class
     */
    public function __construct(public readonly string $class)
    {
    }
}
