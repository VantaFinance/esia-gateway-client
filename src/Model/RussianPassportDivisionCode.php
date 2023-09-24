<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use InvalidArgumentException;

final class RussianPassportDivisionCode
{
    private string $value;

    public function __construct(
        string $value
    ) {
        if (preg_match('/^\d{6}$/', $value)) {
            $value = mb_substr($value, 0, 3) . '-' . mb_substr($value, 3, 3);
        }

        if (!preg_match('/^\d{3}-\d{3}$/m', $value)) {
            throw new InvalidArgumentException('Неверный формат кода подразделения');
        }

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
