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

final class InnNumber
{
    /**
     * @var numeric-string $value
     */
    private readonly string $value;

    /**
     * @param numeric-string $value
     */
    public function __construct(
        string $value
    ) {
        Assert::regex($value, '/^\d{10}(\d{2})?$/', 'Налоговый номер должен быть длиной 10 или 12 символов');

        $this->value = $value;
    }

    /**
     * @return numeric-string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return numeric-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
