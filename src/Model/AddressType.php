<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use MyCLabs\Enum\Enum;

final class AddressType extends Enum
{
    private const PERSISTENT_REGISTRATION = 'PRG';
    private const TEMPORARY_REGISTRATION = 'PTA';
    private const PERSISTENT_LIVING = 'PLV';
}
