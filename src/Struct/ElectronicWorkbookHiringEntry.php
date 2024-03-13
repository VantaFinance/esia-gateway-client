<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;

final class ElectronicWorkbookHiringEntry extends ElectronicWorkbookEntry
{
    /**
     * @param ?non-empty-string $position
     */
    public function __construct(
        #[SerializedPath('[uuid]')]
        public readonly Uuid $id,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public readonly DateTimeImmutable $date,
        public readonly ElectronicWorkbookOrganizationInfo $organization,
        public readonly ?string $position,
        public readonly bool $isPartTimeJob = false,
    ) {
        parent::__construct(ElectronicWorkbookEntryType::HIRING);
    }
}
