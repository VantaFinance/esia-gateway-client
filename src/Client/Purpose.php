<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

enum Purpose: string
{
    case CREDIT        = 'CREDIT';
    case FIN_AGREEMENT = 'FIN_AGREEMENT';
}
