<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Response;

use Brick\PhoneNumber\PhoneNumber;
use DateTimeImmutable;
use Psr\Http\Message\StreamInterface as Stream;
use Vanta\Integration\Esia\Struct\Address;
use Vanta\Integration\Esia\Struct\CountryIso;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\Income\IncomeReference;
use Vanta\Integration\Esia\Struct\Document\Income\IncomeReferenceDateItemIncomeInfo;
use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\SnilsNumber;
use Vanta\Integration\Esia\Struct\Email;
use Vanta\Integration\Esia\Struct\Gender;
use Vanta\Integration\Esia\Struct\Permission;

final readonly class UserInfo
{
    /**
     * @param numeric-string             $uid
     * @param numeric-string             $oid
     * @param list<Document>             $documents
     * @param non-empty-list<Permission> $scope
     */
    public function __construct(
        public string $uid,
        public string $oid,
        public bool $trusted,
        public string $firstName,
        public ?string $middleName,
        public string $lastName,
        public Stream $rawInfo,
        public array $scope,
        public DateTimeImmutable $birthDate,
        public Gender $gender,
        public PhoneNumber $mobilePhone,
        public SnilsNumber $snils,
        public array $documents,
        public ?Email $email = null,
        public ?InnNumber $inn = null,
        public ?CountryIso $citizenship = null,
        public ?Address $homeAddress = null,
        public ?Address $temporaryAddress = null,
        public ?Address $registrationAddress = null,
    ) {
    }

    /**
     * @template T
     *
     * @param class-string<T> $type
     *
     * @return list<T>
     */
    public function getDocumentsByType(string $type): array
    {
        return array_filter($this->documents, static fn (Document $e): bool => $e instanceof $type);
    }

    /**
     * @return list<IncomeReferenceDateItemIncomeInfo>
     */
    public function getLastIncomes(): array
    {
        $incomes     = $this->getDocumentsByType(IncomeReference::class);
        $lastIncomes = [];

        /** @var IncomeReference $income */
        foreach ($incomes as $income) {
            if (null == $income->year) {
                continue;
            }

            foreach ($income->data as $reference) {
                $lastIncomes[$income->year->getValue()] = [
                    ...($lastIncomes[$income->year->getValue()] ?? []),
                    ...$reference->incomeInfo,
                ];
            }
        }

        if ([] == $lastIncomes) {
            return [];
        }

        return max($lastIncomes);
    }
}
