<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

enum DocumentType: string
{
    case RUSSIAN_PASSPORT = 'RF_PASSPORT';
    case RUSSIAN_INTERNATIONAL_PASSPORT = 'FRGN_PASS';
}
