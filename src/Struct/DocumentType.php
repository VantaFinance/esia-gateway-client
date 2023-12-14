<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

enum DocumentType: string
{
    case RUSSIAN_PASSPORT               = 'RF_PASSPORT';
    case RUSSIAN_INTERNATIONAL_PASSPORT = 'FRGN_PASS';
    case SOVIET_PASSPORT                = 'USSR_PASSPORT';
    case DRIVER_LICENSE                 = 'RF_DRIVING_LICENSE';
    case INCOME_REFERENCE               = 'INCOME_REFERENCE';
    case PASSPORT_HISTORY               = 'PASSPORT_HISTORY';
    case UNKNOWN                        = 'UNKNOWN';
}
