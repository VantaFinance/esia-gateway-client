<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use InvalidArgumentException;

final class RussianPassportDivisionCode
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public readonly string $value,
    ) {
        if (preg_match('/^\d{6}$/', $value)) {
            $value = mb_substr($value, 0, 3) . '-' . mb_substr($value, 3, 3);
        }

        if (!preg_match('/^\d{3}-\d{3}$/m', $value)) {
            throw new InvalidArgumentException('Неверный формат кода подразделения');
        }
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
