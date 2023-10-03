<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Brick\DateTime\Year;
use Symfony\Component\Uid\Uuid;

final class IncomeReference extends Document
{
    public function __construct(
        public readonly Uuid $id,
        public readonly Year $year,
        public readonly int $version,
        /** @var list<IncomeReferenceDataItem> $data */
        public array $data,
    ) {
        parent::__construct(DocumentType::INCOME_REFERENCE->value);
    }
}
