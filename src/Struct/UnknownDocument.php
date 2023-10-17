<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
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
