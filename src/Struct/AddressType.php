<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

enum AddressType: string
{
    case PERSISTENT_REGISTRATION = 'PRG';
    case TEMPORARY_REGISTRATION  = 'PTA';
    case PERSISTENT_LIVING       = 'PLV';
}
