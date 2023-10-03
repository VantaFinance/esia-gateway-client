<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;

final class RussianInternationalPassport extends Document
{
    public function __construct(
        /** @var numeric-string $id */
        public readonly string $id,
        public readonly RussianInternationalPassportSeries $series,
        public readonly RussianInternationalPassportNumber $number,
        #[SerializedPath('[issueDate]')]
        public readonly DateTimeImmutable $issuedAt,
        public readonly ?string $issuedBy,
    ) {
        parent::__construct(DocumentType::RUSSIAN_INTERNATIONAL_PASSPORT->value);
    }
}
