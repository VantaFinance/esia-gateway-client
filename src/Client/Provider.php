<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use MyCLabs\Enum\Enum;

final class Provider extends Enum
{
    private const ESIA_OAUTH = 'esia_oauth';
}
