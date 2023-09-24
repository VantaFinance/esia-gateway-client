<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;

final class RussianInternationalPassport
{
    private int $id;

    private RussianInternationalPassportSeries $series;

    private RussianInternationalPassportNumber $number;

    /**
     * @SerializedPath("[issueDate]")
     */
    private DateTimeImmutable $issuedAt;

    private ?string $issuedBy;

    /**
     * @param int $id
     * @param RussianInternationalPassportSeries $series
     * @param RussianInternationalPassportNumber $number
     * @param DateTimeImmutable $issuedAt
     * @param string $issuedBy
     */
    public function __construct(int $id, RussianInternationalPassportSeries $series, RussianInternationalPassportNumber $number, DateTimeImmutable $issuedAt, ?string $issuedBy)
    {
        $this->id       = $id;
        $this->series   = $series;
        $this->number   = $number;
        $this->issuedAt = $issuedAt;
        $this->issuedBy = $issuedBy;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSeries(): RussianInternationalPassportSeries
    {
        return $this->series;
    }

    public function getNumber(): RussianInternationalPassportNumber
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
}
