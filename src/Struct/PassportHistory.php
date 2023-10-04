<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Uid\Uuid;

final class PassportHistory extends Document
{
    /**
     * @param list<PreviousDocument> $history
     */
    public function __construct(
        public Uuid $id,
        public int $version,
        public array $history,
    ) {
        parent::__construct(DocumentType::PASSPORT_HISTORY->value);
    }
}
