<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Symfony\Component\Serializer\Annotation\SerializedPath;
use Symfony\Component\Uid\NilUuid;
use Symfony\Component\Uid\Uuid;

final class Address
{
    /**
     * @param non-empty-string|null $region
     * @param non-empty-string|null $city
     * @param non-empty-string|null $district
     * @param non-empty-string|null $area
     * @param non-empty-string|null $settlement
     * @param non-empty-string|null $additionArea
     * @param non-empty-string|null $additionAreaStreet
     * @param non-empty-string|null $street
     * @param non-empty-string|null $house
     * @param non-empty-string|null $frame
     * @param non-empty-string|null $flat
     * @param non-empty-string|null $room
     * @param non-empty-string|null $zipCode
     * @param non-empty-string|null $fiasCodeLevel
     * @param non-empty-string|null $addressStr
     */
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
        public readonly ?string $fiasCodeLevel,
        public readonly ?string $addressStr,
        public readonly Uuid $fiasCode = new NilUuid(),
    ) {
    }
}
