<?php
/**
 * PosCredit MDM
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Uid\Uuid;

final class ElectronicWorkbook extends Document
{
    /**
     * @param list<ElectronicWorkbookEntry> $events
     */
    public function __construct(
        public readonly ?Uuid $id,
        public int $version,
        public array $events,
    ) {
        parent::__construct(DocumentType::ELECTRONIC_WORKBOOK);
    }
}
