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
use Psr\Http\Message\StreamInterface as Stream;
use Vanta\Integration\EsiaGateway\Client\Scope;

final class UserInfo
{
    /**
     * @param numeric-string $uid
     * @param list<Document> $documents
     */
    public function __construct(
        public readonly string $uid,
        public readonly bool $trusted,
        public readonly string $firstName,
        public readonly ?string $middleName,
        public readonly string $lastName,
        public readonly Stream $rawInfo,
        public readonly Scope $scope,
        public readonly DateTimeImmutable $birthDate,
        public readonly Gender $gender,
        public readonly PhoneNumber $mobilePhone,
        public readonly SnilsNumber $snils,
        public array $documents,
        public readonly ?Email $email = null,
        public readonly ?InnNumber $inn = null,
        public readonly ?CountryIso $citizenship = null,
        public readonly ?Address $homeAddress = null,
        public readonly ?Address $temporaryAddress = null,
        public readonly ?Address $registrationAddress = null,
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

            /** @var IncomeReferenceDataItem $reference */
            foreach (array_merge(...array_column($incomes, 'data')) as $reference) {
                $lastIncomes[$income->year->getValue()][] = $reference->incomeInfo;
            }
        }

        if ([] == $lastIncomes) {
            return [];
        }

        return array_merge(...max($lastIncomes));
    }
}
