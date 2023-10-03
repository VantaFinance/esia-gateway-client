<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Serializer\Annotation as Serializer;

#[Serializer\DiscriminatorMap(
    typeProperty: 'passportType',
    mapping: [
        'rf_passport' => PreviousRussianPassport::class,
        'frgn_pass'   => PreviousRussianInternationalPassport::class,
    ],
)]
abstract class PreviousDocument extends Document
{
    #[Serializer\SerializedPath('[passportType]')]
    protected string $type;
}
