<?php
/**
 * PosCredit MDM
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

final class UnknownDocument extends Document
{
    public function __construct()
    {
        parent::__construct(DocumentType::UNKNOWN->value);
    }
}
