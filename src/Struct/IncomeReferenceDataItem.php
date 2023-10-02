<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Serializer\Annotation\SerializedPath;

final class IncomeReferenceDataItem
{
    public function __construct(
        #[SerializedPath("[orgInfo]")]
        public readonly IncomeReferenceDateItemOrganizationInfo $organizationInfo,
        /** @var IncomeReferenceDateItemIncomeInfo[] $incomeInfo */
        #[SerializedPath("[incInfo]")]
        public array $incomeInfo,
    ) {
    }
}
