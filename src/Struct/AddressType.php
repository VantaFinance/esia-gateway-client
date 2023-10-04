<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

enum AddressType: string
{
    case PERSISTENT_REGISTRATION = 'PRG';
    case TEMPORARY_REGISTRATION  = 'PTA';
    case PERSISTENT_LIVING       = 'PLV';
}
