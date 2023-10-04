<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;

final class RussianInternationalPassport extends Document
{
    /**
     * @param numeric-string $id
     */
    public function __construct(
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
