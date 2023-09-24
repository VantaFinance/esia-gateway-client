<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use Symfony\Component\Serializer\Annotation\SerializedPath;

final class DocumentList
{
    /**
     * @var list<RussianPassport>
     *
     * @SerializedPath("[rf_passport]")
     */
    private array $russianPassports = [];

    /**
     * @var list<RussianInternationalPassport>
     *
     * @SerializedPath("[frgn_pass]")
     */
    private array $russianInternationalPassports = [];

    /**
     * @param RussianPassport[] $russianPassports
     * @param RussianInternationalPassport[] $russianInternationalPassports
     */
    public function __construct(array $russianPassports, array $russianInternationalPassports)
    {
        $this->russianPassports              = $russianPassports;
        $this->russianInternationalPassports = $russianInternationalPassports;
    }

    public function addRussianPassport(RussianPassport $russianPassport): void
    {
        $this->russianPassports[] = $russianPassport;
    }

    /**
     * @return list<RussianPassport>
     */
    public function getRussianPassports(): array
    {
        return $this->russianPassports;
    }

    public function addRussianInternationalPassport(RussianInternationalPassport $russianInternationalPassport): void
    {
        $this->russianInternationalPassports[] = $russianInternationalPassport;
    }

    /**
     * @return list<RussianInternationalPassport>
     */
    public function getRussianInternationalPassports(): array
    {
        return $this->russianInternationalPassports;
    }
}
