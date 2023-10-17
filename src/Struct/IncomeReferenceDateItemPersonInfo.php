<?php
/**
 * PosCredit MDM
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

final class IncomeReferenceDateItemPersonInfo
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly ?string $middleName,
        public readonly InnNumber $inn,
    ) {
    }
}
