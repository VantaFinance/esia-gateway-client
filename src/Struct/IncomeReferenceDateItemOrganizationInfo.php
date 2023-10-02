<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

final class IncomeReferenceDateItemOrganizationInfo
{
    public function __construct(
        public readonly string $fullName,
        public readonly InnNumber $inn,
        // TODO: Might be a value object as well
        public readonly string $kpp,
    ) {
    }
}
