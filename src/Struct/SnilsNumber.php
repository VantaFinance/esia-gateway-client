<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Webmozart\Assert\Assert;

final class SnilsNumber
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
        Assert::regex($value, '/^\d{3}-\d{3}-\d{3} \d{2}$/', 'Неверный формат данных, ожидаемый формат: XXX-XXX-XXX XX');

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
