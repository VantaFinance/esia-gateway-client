<?php
/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Parser;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\BigDecimalNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\DateTimeUnixTimeNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\InnNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\KppNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\PhoneNumberNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\TaxAgentNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\TwoNDFLDNormalizer;
use Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer\YearNormalizer;
use Vanta\Integration\EsiaGateway\Struct\IncomeReference;
use Vanta\Integration\EsiaGateway\Struct\TwoNDFL;

final class TwoNDFLDParser
{
    private readonly Serializer $serializer;

    public function __construct(?Serializer $serializer = null)
    {
        if (null == $serializer) {
            $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

            $serializer = new SymfonySerializer([
                new UnwrappingDenormalizer(),
                new TwoNDFLDNormalizer(),
                new TaxAgentNormalizer(),
                new InnNumberNormalizer(),
                new KppNumberNormalizer(),
                new BackedEnumNormalizer(),
                new UidNormalizer(),
                new PhoneNumberNormalizer(),
                new YearNormalizer(),
                new BigDecimalNormalizer(),
                new DateTimeUnixTimeNormalizer(
                    new DateTimeNormalizer([
                        DateTimeNormalizer::FORMAT_KEY => 'd.M.Y',
                    ])
                ),
                new ObjectNormalizer(
                    $classMetadataFactory,
                    new MetadataAwareNameConverter($classMetadataFactory),
                    null,
                    new PropertyInfoExtractor(
                        [],
                        [new PhpStanExtractor()],
                        [],
                        [],
                        []
                    ),
                    new ClassDiscriminatorFromClassMetadata($classMetadataFactory),
                ),
                new ArrayDenormalizer(),
            ], [new XmlEncoder(['xml_type_cast_attributes' => false])]);
        }

        $this->serializer = $serializer;
    }

    /**
     * @param list<IncomeReference> $documents
     *
     * @return array<TwoNDFL>
     */
    public function parse(array $documents): array
    {
        $newDocs = [];

        foreach (array_merge(...array_map(static fn (IncomeReference $e): array => $e->getFilesByTypes(['application/xml']), $documents)) as $file) {
            $newDocs[] = $this->serializer->deserialize($file->content->read(), TwoNDFL::class, 'xml');
        }

        return $newDocs;
    }
}
