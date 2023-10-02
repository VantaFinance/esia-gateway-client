<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;

final class DriverLicense extends Document
{
    public function __construct(
        public readonly string $id,
        public readonly DriverLicenseSeries $series,
        public readonly DriverLicenseNumber $number,
        #[SerializedPath('[issueDate]')]
        public readonly DateTimeImmutable $issuedAt,
    ) {
        parent::__construct(DocumentType::DRIVER_LICENSE->value);
    }
}
