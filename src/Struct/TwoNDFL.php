<?php
/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Brick\DateTime\Year;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer as ObjectNormalizer;

final class TwoNDFL
{
    /**
     * @param non-empty-string    $id
     * @param non-empty-string    $version
     * @param list<TwoNdflIncome> $incomes
     * @param positive-int        $count
     */
    public function __construct(
        #[SerializedName('@ИдФайл')]
        public string $id,
        #[SerializedName('@ВерсФорм')]
        public string $version,
        #[SerializedPath('[Документ][@ДатаДок]')]
        public DateTimeImmutable $createdAt,
        #[SerializedPath('[Документ][@ОтчетГод]')]
        public Year $year,
        #[SerializedPath('[Документ][СвНА]')]
        public TaxAgent $taxAgent,
        #[SerializedPath('[Документ][СправДох][ПолучДох]')]
        public TwoNDFLPerson $person,
        #[SerializedPath('[Документ][СправДох][СведДох][@Ставка]')]
        #[Context([ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public float $taxRate,
        #[SerializedPath('[Документ][СправДох][СведДох][СумИтНалПер]')]
        public TwoNDFLSummary $summary,
        #[SerializedPath('[Документ][СправДох][СведДох][ДохВыч][СвСумДох]')]
        public array $incomes,
        #[SerializedName('@КолДок')]
        #[Context([ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public int $count = 1,
    ) {
    }
}
