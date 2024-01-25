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

final class TwoNdflDeduction
{
    public function __construct(
        #[SerializedName('@КодВычет')]
        public string $code,
        #[SerializedName('@СумВычет')]
        public BigDecimal $sum,
    ) {
    }
}
