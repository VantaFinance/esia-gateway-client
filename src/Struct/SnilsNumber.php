<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Webmozart\Assert\Assert;

final class SnilsNumber
{
    /**
     * @var non-empty-string $value
     */
    private readonly string $value;

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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
