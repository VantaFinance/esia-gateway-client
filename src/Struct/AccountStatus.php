<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

enum AccountStatus: string
{
    case REGISTERED = 'REGISTERED';
    // TODO: See if we will even ever get this; PDF guide mentions that it is possible
    case DELETED = 'DELETED';
}
