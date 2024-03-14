<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Serializer\Annotation as Serializer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Attributes\DiscriminatorDefault;

#[DiscriminatorDefault(UnknownDocument::class)]
#[Serializer\DiscriminatorMap(
    typeProperty: 'type',
    mapping: [
        'RF_PASSPORT'         => RussianPassport::class,
        'FRGN_PASS'           => RussianInternationalPassport::class,
        'RF_DRIVING_LICENSE'  => DriverLicense::class,
        'INCOME_REFERENCE'    => IncomeReference::class,
        'PASSPORT_HISTORY'    => PassportHistory::class,
        'ELECTRONIC_WORKBOOK' => ElectronicWorkbook::class,
    ],
)]
abstract class Document
{
    public readonly DocumentType $type;

    public function __construct(DocumentType $type)
    {
        $this->type = $type;
    }
}
