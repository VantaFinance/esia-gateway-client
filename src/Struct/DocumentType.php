<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

enum DocumentType: string
{
    case RUSSIAN_PASSPORT = 'RF_PASSPORT';
    case RUSSIAN_INTERNATIONAL_PASSPORT = 'FRGN_PASS';
    case DRIVER_LICENSE = 'RF_DRIVING_LICENSE';
    case INCOME_REFERENCE = 'INCOME_REFERENCE';
    case PASSPORT_HISTORY = 'PASSPORT_HISTORY';
}
