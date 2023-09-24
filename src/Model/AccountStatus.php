<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use MyCLabs\Enum\Enum;

final class AccountStatus extends Enum
{
    private const REGISTERED = "REGISTERED";
    // TODO: See if we will even ever get this; PDF guide mentions that it is possible
    private const DELETED = "DELETED";
}
