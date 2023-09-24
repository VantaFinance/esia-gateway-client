<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Model;

use InvalidArgumentException;

final class CountryIso
{
    /**
     * @param non-empty-string $value
     */
    private string $value;

    /**
     * @param non-empty-string $value
     */
    public function __construct(
        string $value
    ) {
        if (!preg_match('/^[a-zA-Z]{3}$/', $value)) {
            throw new InvalidArgumentException('Invalid country ISO code, must be an ISO 3166-1 alpha-3 code');
        }

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
