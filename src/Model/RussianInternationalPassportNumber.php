<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use Webmozart\Assert\Assert;

final class RussianInternationalPassportNumber
{
    private string $value;

    public function __construct(
        string $value
    ) {
        Assert::regex($value, '/^\d{7}$/', 'Неверный формат номера документа, ожидается 7 цифр');

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
