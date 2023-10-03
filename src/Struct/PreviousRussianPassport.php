<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;

final class PreviousRussianPassport extends PreviousDocument
{
    public function __construct(
        public readonly RussianPassportSeries $series,
        public readonly RussianPassportNumber $number,
        #[SerializedPath('[issueDate]')]
        public readonly DateTimeImmutable $issuedAt,
        public readonly ?string $issuedBy,
        #[SerializedPath('[issueId]')]
        public readonly RussianPassportDivisionCode $divisionCode,
    ) {
        parent::__construct(DocumentType::RUSSIAN_PASSPORT->value);
    }
}
