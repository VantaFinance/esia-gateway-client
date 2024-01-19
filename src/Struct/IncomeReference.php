<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Brick\DateTime\Year;
use Symfony\Component\Uid\Uuid;

final class IncomeReference extends Document
{
    /**
     * @param ?list<IncomeReferenceDataItem> $data
     */
    public function __construct(
        public readonly ?Uuid $id,
        public readonly ?Year $year,
        public readonly ?int $version,
        public ?array $data,
    ) {
        parent::__construct(DocumentType::INCOME_REFERENCE);
    }
}
