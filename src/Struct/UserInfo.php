<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Brick\PhoneNumber\PhoneNumber;
use DateTimeImmutable;

final class UserInfo
{
    public function __construct(
        /** @var numeric-string $uid */
        public readonly string $uid,
        public readonly bool $trusted,

        public readonly string $firstName,
        public readonly string $middleName,
        public readonly string $lastName,
        public readonly CountryIso $citizenship,
        public readonly DateTimeImmutable $birthDate,
        public readonly Gender $gender,

        public readonly Email $email,
        public readonly PhoneNumber $mobilePhone,

        public readonly SnilsNumber $snils,
        public readonly InnNumber $inn,
        /** @var list<Document> $documents */
        public array $documents,

        public readonly Address $registrationAddress,
        public readonly Address $homeAddress,
    ) {
    }
}
