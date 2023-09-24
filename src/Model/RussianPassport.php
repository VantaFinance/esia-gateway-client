<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;

final class RussianPassport
{
    private int $id;

    private RussianPassportSeries $series;

    private RussianPassportNumber $number;

    /**
     * @SerializedPath("[issueDate]")
     */
    private DateTimeImmutable $issuedAt;

    private ?string $issuedBy;

    /**
     * @SerializedPath("[issueId]")
     */
    private RussianPassportDivisionCode $divisionCode;

    /**
     * @param int $id
     * @param RussianPassportSeries $series
     * @param RussianPassportNumber $number
     * @param DateTimeImmutable $issuedAt
     * @param ?string $issuedBy
     * @param RussianPassportDivisionCode $divisionCode
     */
    public function __construct(int $id, RussianPassportSeries $series, RussianPassportNumber $number, DateTimeImmutable $issuedAt, ?string $issuedBy, RussianPassportDivisionCode $divisionCode)
    {
        $this->id           = $id;
        $this->series       = $series;
        $this->number       = $number;
        $this->issuedAt     = $issuedAt;
        $this->issuedBy     = $issuedBy;
        $this->divisionCode = $divisionCode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSeries(): RussianPassportSeries
    {
        return $this->series;
    }

    public function getNumber(): RussianPassportNumber
    {
        return $this->number;
    }

    public function getIssuedAt(): DateTimeImmutable
    {
        return $this->issuedAt;
    }

    public function getIssuedBy(): ?string
    {
        return $this->issuedBy;
    }

    public function getDivisionCode(): RussianPassportDivisionCode
    {
        return $this->divisionCode;
    }
}
