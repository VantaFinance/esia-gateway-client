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
     * @param list<Base64File>                        $files
     * @param list<IncomeReferenceDateItemIncomeInfo> $incomeInfo
     */
    public function __construct(
        #[SerializedPath('[orgInfo]')]
        public readonly ?IncomeReferenceDateItemOrganizationInfo $organizationInfo,
        #[SerializedPath('[personInfo]')]
        public readonly ?IncomeReferenceDateItemPersonInfo $personInfo,
        #[SerializedPath('[incInfo]')]
        public array $incomeInfo,
        public array $files = [],
    ) {
    }

    /**
     * @param non-empty-list<non-empty-string> $types
     *
     * @return list<Base64File>
     */
    public function getFilesByTypes(array $types): array
    {
        return array_filter($this->files, static fn (Base64File $e): bool => in_array($e->metadata, $types));
    }
}
