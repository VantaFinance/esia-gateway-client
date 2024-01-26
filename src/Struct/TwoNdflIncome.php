<?php
/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Brick\Math\BigDecimal;
use Symfony\Component\Serializer\Attribute\SerializedName;

final class TwoNdflIncome
{
    public function __construct(
        #[SerializedName('@Месяц')]
        public string $month,
        #[SerializedName('@КодДоход')]
        public string $revenueCode,
        #[SerializedName('@СумДоход')]
        public BigDecimal $sumIncome,
        #[SerializedName('СвСумВыч')]
        public ?TwoNdflDeduction $deduction = null,
    ) {
    }
}
