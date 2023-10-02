<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

final class IncomeReferenceDateItemIncomeInfo
{
    public function __construct(
        // TODO: Work with Brick/Money
        public readonly string $rate,
        public readonly string $income,
        public readonly string $tax,
    ) {
    }
}
