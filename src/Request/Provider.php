<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Request;

enum Provider: string
{
    case ESIA_OAUTH = 'esia_oauth';
    case CPG_OAUTH  = 'cpg_oauth';
}
