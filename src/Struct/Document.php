<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Serializer\Annotation as Serializer;

#[Serializer\DiscriminatorMap(
    typeProperty: 'type',
    mapping: [
        'RF_PASSPORT'   => RussianPassport::class,
        'FRGN_PASSPORT' => RussianInternationalPassport::class,
    ],
)]
abstract class Document
{
    protected string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    final public function getType(): string
    {
        return $this->type;
    }
}
