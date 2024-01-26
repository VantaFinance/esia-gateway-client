<?php

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Struct;

use Amp\ByteStream\Base64\Base64DecodingReadableStream;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final class Base64File
{
    /**
     * @param non-empty-string $name
     * @param non-empty-string $metadata
     */
    public function __construct(
        public readonly string $name,
        public readonly string $metadata,
        #[SerializedPath('[createdOn]')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public readonly DateTimeImmutable $createdAt,
        #[SerializedPath('[updatedOn]')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public readonly DateTimeImmutable $updatedAt,
        #[SerializedPath('[file]')]
        public readonly Base64DecodingReadableStream $content,
        #[SerializedPath('[sign]')]
        public readonly Base64DecodingReadableStream $sign,
    ) {
    }
}
