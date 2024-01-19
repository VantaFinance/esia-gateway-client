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
use Stringable;

final class DriverLicenseSeries implements Stringable
{
    /**
     * @var non-empty-string
     */
    public readonly string $value;

    /**
     * @param non-empty-string $value
     */
    public function __construct(
        string $value,
    ) {
        if (!preg_match('/^\d{4}$/', $value) && !mb_ereg('\d{2}[а-яА-Я]{2}', $value)) {
            throw new InvalidArgumentException('Ожидаем 4 цифры или 2 цифры и 2 буквы');
        }

        $this->value = $value;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
