<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Brick\PhoneNumber\PhoneNumber;
use DateTimeImmutable;
use Vanta\Integration\EsiaGateway\Client\Scope;

final class UserInfo
{
    /**
     * @param numeric-string $uid
     * @param non-empty-string $rawInfo
     * @param list<Document> $documents
     */
    public function __construct(
        public readonly string $uid,
        public readonly bool $trusted,
        public readonly string $firstName,
        public readonly ?string $middleName,
        public readonly string $lastName,
        public readonly string $rawInfo,
        public readonly Scope $scope,
        public readonly CountryIso $citizenship,
        public readonly DateTimeImmutable $birthDate,
        public readonly Gender $gender,
        public readonly Email $email,
        public readonly PhoneNumber $mobilePhone,
        public readonly SnilsNumber $snils,
        public array $documents,
        public readonly ?InnNumber $inn = null,
        public readonly ?Address $registrationAddress = null,
        public readonly ?Address $homeAddress = null,
        public readonly ?Address $temporaryAddress = null,
    ) {
    }
}
