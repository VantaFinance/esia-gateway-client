<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Webmozart\Assert\Assert;

final class InnNumber
{
    private readonly string $value;

    public function __construct(
        string $value
    ) {
        Assert::regex($value, '/^\d{10}(\d{2})?$/', 'Налоговый номер должен быть длиной 10 или 12 символов');

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
