<?php
/**
 * PosCredit MDM
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class DiscriminatorDefault
{
    public function __construct(public readonly string $class)
    {
    }
}
