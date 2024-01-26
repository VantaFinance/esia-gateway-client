<?php
/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\SerializedPath;

final class TwoNDFLPerson
{
    /**
     * @param non-empty-string      $firstname
     * @param non-empty-string      $lastname
     * @param non-empty-string      $passport
     * @param non-empty-string|null $surname
     */
    public function __construct(
        #[SerializedPath('[@ДатаРожд]')]
        public DateTimeImmutable $birthAt,
        #[SerializedPath('[ФИО][@Имя]')]
        public string $firstname,
        #[SerializedPath('[ФИО][@Фамилия]')]
        public string $lastname,
        #[SerializedPath('[УдЛичнФЛ][@СерНомДок]')]
        public string $passport,
        #[SerializedPath('[ФИО][@Отчество]')]
        public ?string $surname = null,
        #[SerializedPath('[@ИННФЛ]')]
        public ?InnNumber $inn = null,
    ) {
    }
}
