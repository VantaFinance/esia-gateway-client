<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
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
