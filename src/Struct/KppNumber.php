<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Webmozart\Assert\Assert;

final class KppNumber
{
    private readonly string $value;

    public function __construct(
        string $value
    ) {
        Assert::regex($value, '/^\d{9}$/', 'КПП должен состоять из 9 цифр');

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
