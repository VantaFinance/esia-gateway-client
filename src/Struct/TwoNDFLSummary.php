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

final class TwoNDFLSummary
{
    public function __construct(
        #[SerializedName('@СумДохОбщ')]
        public BigDecimal $totalIncome,
        #[SerializedName('@НалБаза')]
        public BigDecimal $taxBase,
        #[SerializedName('@НалИсчисл')]
        public BigDecimal $taxAmountCalculated,
        #[SerializedName('@НалУдерж')]
        public BigDecimal $amountTaxWithheld,
        #[SerializedName('@АвансПлатФикс')]
        public BigDecimal $fixedAmountAdvancePayments,
        #[SerializedName('@НалПеречисл')]
        public BigDecimal $taxAmountTransferred,
    ) {
    }
}
