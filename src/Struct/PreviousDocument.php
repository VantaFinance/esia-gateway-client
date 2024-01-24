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

#[DiscriminatorDefault(UnknownPreviousDocument::class)]
#[Serializer\DiscriminatorMap(
    typeProperty: 'passportType',
    mapping: [
        'rf_passport'   => PreviousRussianPassport::class,
        'frgn_pass'     => PreviousRussianInternationalPassport::class,
        'ussr_passport' => PreviousSovietPassport::class,
    ],
)]
abstract class PreviousDocument extends Document
{
    #[Serializer\SerializedPath('[passportType]')]
    public readonly DocumentType $type;

    public function __construct(DocumentType $type)
    {
        $this->type = $type;
    }
}
