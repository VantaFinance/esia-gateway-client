<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Webmozart\Assert\Assert;

final class InnNumber
{
    private string $value;

    public function __construct(
        string $value
    ) {
        Assert::regex($value, '/^\d{12}$/', 'Налоговый номер для физического лица должен быть длиной 12 символов');

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
