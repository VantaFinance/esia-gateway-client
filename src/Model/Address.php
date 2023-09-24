<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use Symfony\Component\Serializer\Annotation\SerializedPath;
use Symfony\Component\Uid\Uuid;

final class Address
{
    private int $id;

    private AddressType $type;

    /**
     * @SerializedPath("[countryId]")
     */
    private CountryIso $countryIso;

    private ?string $region = null;

    private ?string $city = null;

    private ?string $district = null;

    private ?string $area = null;

    private ?string $settlement = null;

    private ?string $additionArea = null;

    private ?string $additionAreaStreet = null;

    private ?string $street = null;

    private ?string $house = null;

    private ?string $frame = null;

    private ?string $flat = null;

    private ?string $room = null;

    /**
     * @var numeric-string|null
     */
    private ?string $zipCode = null;

    private ?Uuid $fiasCode = null;

    /**
     * @SerializedPath("[fiasCodeLevel]")
     */
    private ?string $fiasLevel = null;

    /**
     * @param int $id
     * @param AddressType $type
     * @param CountryIso $countryIso
     * @param string|null $region
     * @param string|null $city
     * @param string|null $district
     * @param string|null $area
     * @param string|null $settlement
     * @param string|null $additionArea
     * @param string|null $additionAreaStreet
     * @param string|null $street
     * @param string|null $house
     * @param string|null $frame
     * @param string|null $flat
     * @param string|null $room
     * @param string|null $zipCode
     * @param Uuid|null $fiasCode
     * @param string|null $fiasLevel
     */
    public function __construct(int $id, AddressType $type, CountryIso $countryIso, ?string $region, ?string $city, ?string $district, ?string $area, ?string $settlement, ?string $additionArea, ?string $additionAreaStreet, ?string $street, ?string $house, ?string $frame, ?string $flat, ?string $room, ?string $zipCode, ?Uuid $fiasCode, ?string $fiasLevel)
    {
        $this->id                 = $id;
        $this->type               = $type;
        $this->countryIso         = $countryIso;
        $this->region             = $region;
        $this->city               = $city;
        $this->district           = $district;
        $this->area               = $area;
        $this->settlement         = $settlement;
        $this->additionArea       = $additionArea;
        $this->additionAreaStreet = $additionAreaStreet;
        $this->street             = $street;
        $this->house              = $house;
        $this->frame              = $frame;
        $this->flat               = $flat;
        $this->room               = $room;
        $this->zipCode            = $zipCode;
        $this->fiasCode           = $fiasCode;
        $this->fiasLevel          = $fiasLevel;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): AddressType
    {
        return $this->type;
    }

    public function getCountryIso(): CountryIso
    {
        return $this->countryIso;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function getSettlement(): ?string
    {
        return $this->settlement;
    }

    public function getAdditionArea(): ?string
    {
        return $this->additionArea;
    }

    public function getAdditionAreaStreet(): ?string
    {
        return $this->additionAreaStreet;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getHouse(): ?string
    {
        return $this->house;
    }

    public function getFrame(): ?string
    {
        return $this->frame;
    }

    public function getFlat(): ?string
    {
        return $this->flat;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function getFiasCode(): ?Uuid
    {
        return $this->fiasCode;
    }

    public function getFiasLevel(): ?string
    {
        return $this->fiasLevel;
    }
}
