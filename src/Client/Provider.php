<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

enum Provider: string
{
    case ESIA_OAUTH = 'esia_oauth';
    case CPG_OAUTH = 'cpg_oauth';
}
