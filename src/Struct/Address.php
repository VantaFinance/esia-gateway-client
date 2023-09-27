<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Serializer\Annotation\SerializedPath;
use Symfony\Component\Uid\Uuid;

final class Address
{
    public function __construct(
        #[SerializedPath('[countryId]')]
        public readonly CountryIso $countryIso,
        public readonly ?string $region,
        public readonly ?string $city,
        public readonly ?string $district,
        public readonly ?string $area,
        public readonly ?string $settlement,
        public readonly ?string $additionArea,
        public readonly ?string $additionAreaStreet,
        public readonly ?string $street,
        public readonly ?string $house,
        public readonly ?string $frame,
        public readonly ?string $flat,
        public readonly ?string $room,
        public readonly ?string $zipCode,
        public readonly ?Uuid $fiasCode,
        public readonly ?string $fiasCodeLevel,
    ) {
    }
}
