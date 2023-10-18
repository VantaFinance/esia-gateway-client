<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Serializer\Annotation\SerializedPath;

final class IncomeReferenceDataItem
{
    /**
     * @param list<IncomeReferenceDateItemIncomeInfo> $incomeInfo
     */
    public function __construct(
        #[SerializedPath('[orgInfo]')]
        public readonly ?IncomeReferenceDateItemOrganizationInfo $organizationInfo,
        #[SerializedPath('[personInfo]')]
        public readonly ?IncomeReferenceDateItemPersonInfo $personInfo,
        #[SerializedPath('[incInfo]')]
        public array $incomeInfo,
    ) {
    }
}
