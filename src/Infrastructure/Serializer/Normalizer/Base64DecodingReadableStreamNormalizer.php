<?php
/**
 * ESIA Gateway Client
 *
 * @author Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Infrastructure\Serializer\Normalizer;

use Amp\ByteStream\Base64\Base64DecodingReadableStream;
use Amp\ByteStream\ReadableResourceStream;
use Amp\ByteStream\StreamException;
use InvalidArgumentException;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Webmozart\Assert\Assert;

final class Base64DecodingReadableStreamNormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Base64DecodingReadableStream
    {
        try {
            Assert::stringNotEmpty($data);

            $stream = fopen('php://memory', 'r+');

            Assert::resource($stream);

            fwrite($stream, $data);
            rewind($stream);

            return new Base64DecodingReadableStream(new ReadableResourceStream($stream));
        } catch (InvalidArgumentException|StreamException $e) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                $e->getMessage(),
                $data,
                [Type::BUILTIN_TYPE_STRING],
                $context['deserialization_path'] ?? null,
                true
            );
        }
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Base64DecodingReadableStream::class == $type;
    }
}
