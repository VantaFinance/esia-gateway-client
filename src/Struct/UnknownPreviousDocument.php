<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

final class UnknownPreviousDocument extends PreviousDocument
{
    public function __construct()
    {
        parent::__construct(DocumentType::UNKNOWN);
    }
}
