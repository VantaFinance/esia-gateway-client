<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Serializer\Attribute\DiscriminatorMap;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Attributes\DiscriminatorDefault;

#[DiscriminatorDefault(ElectronicWorkbookUnknownEntry::class)]
#[DiscriminatorMap(
    typeProperty: 'type',
    mapping: [
        1 => ElectronicWorkbookHiringEntry::class,
        5 => ElectronicWorkbookDismissalEntry::class,
    ],
)]
abstract class ElectronicWorkbookEntry
{
    public readonly ElectronicWorkbookEntryType $type;

    public function __construct(ElectronicWorkbookEntryType $type)
    {
        $this->type = $type;
    }

    final public function isHiring(): bool
    {
        return $this->type == ElectronicWorkbookEntryType::HIRING;
    }

    final public function isDismissal(): bool
    {
        return $this->type == ElectronicWorkbookEntryType::DISMISSAL;
    }
}
