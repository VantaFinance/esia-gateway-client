<?php
/**
 * PosCredit MDM
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Uid\Uuid;

final class ElectronicWorkbookUnknownEntry extends ElectronicWorkbookEntry
{
    public function __construct(
        #[SerializedPath('[uuid]')]
        public readonly Uuid $id,
    ) {
        parent::__construct(ElectronicWorkbookEntryType::UNKNOWN);
    }
}
