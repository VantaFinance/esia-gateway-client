<?php
/**
 * PosCredit MDM
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

enum ElectronicWorkbookEntryType: string
{
    case HIRING    = 'HIRING';
    case DISMISSAL = 'DISMISSAL';
    case UNKNOWN   = 'UNKNOWN';
}
