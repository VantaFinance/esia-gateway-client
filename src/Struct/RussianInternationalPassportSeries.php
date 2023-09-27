<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Webmozart\Assert\Assert;

final class RussianInternationalPassportSeries
{
    private string $value;

    public function __construct(
        string $value
    ) {
        Assert::regex($value, '/^\d{2}$/', 'Неверный формат серии документа, ожидается 2 цифры');

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
