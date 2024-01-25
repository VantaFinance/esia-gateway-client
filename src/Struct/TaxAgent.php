<?php
/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Brick\PhoneNumber\PhoneNumber;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;

final class TaxAgent
{
    public function __construct(
        #[SerializedName('@ОКТМО')]
        public string $octmo,
        #[SerializedPath('[СвНАЮЛ][@НаимОрг]')]
        public string $name,
        #[SerializedPath('[СвНАЮЛ][@ИННЮЛ]')]
        public InnNumber $inn,
        #[SerializedPath('[СвНАЮЛ][@КПП]')]
        public KppNumber $kpp,
        #[SerializedName('@Тлф')]
        public ?PhoneNumber $phoneNumber = null,
    ) {
    }
}
