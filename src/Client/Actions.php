<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

enum Actions: string
{
    case ALL_ACTIONS_TO_DATA = 'ALL_ACTIONS_TO_DATA';
    case SHARE_DATA = 'SHARE_DATA';
    case USE_DATA = 'USE_DATA';
}
