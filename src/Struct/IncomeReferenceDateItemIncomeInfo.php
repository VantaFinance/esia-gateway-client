<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Brick\Math\BigDecimal;

final class IncomeReferenceDateItemIncomeInfo
{
    public function __construct(
        public readonly BigDecimal $rate,
        public readonly BigDecimal $income,
        public readonly BigDecimal $tax,
    ) {
    }
}
