<?php
/**
 * ESIA Gateway Client
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2023, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\EsiaGateway\Client;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedPath;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final class PairKey
{
    /**
     * @var non-empty-string
     */
    #[SerializedPath('[access_token]')]
    public readonly string $accessToken;

    /**
     * @var non-empty-string Always "Bearer"
     */
    #[SerializedPath('[token_type]')]
    public readonly string $tokenType;

    /**
     * @var non-empty-string
     */
    #[SerializedPath('[refresh_token]')]
    public readonly string $refreshToken;

    /**
     * @var non-empty-string
     */
    #[SerializedPath('[id_token]')]
    public readonly string $tokenId;

    public readonly Scope $scope;

    /**
     * @var positive-int
     */
    #[SerializedPath('[expires_in]')]
    public readonly int $expiresIn;

    #[SerializedPath('[created_at]')]
    #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U'])]
    public readonly DateTimeImmutable $createdAt;

    /**
     * @param non-empty-string $tokenId
     * @param non-empty-string $tokenType
     * @param positive-int     $expiresIn
     * @param non-empty-string $accessToken
     * @param non-empty-string $refreshToken
     */
    public function __construct(
        string $accessToken,
        string $tokenType,
        int $expiresIn,
        DateTimeImmutable $createdAt,
        string $refreshToken,
        string $tokenId,
        Scope $scope
    ) {
        $this->scope        = $scope;
        $this->tokenId      = $tokenId;
        $this->createdAt    = $createdAt;
        $this->tokenType    = $tokenType;
        $this->expiresIn    = $expiresIn;
        $this->accessToken  = $accessToken;
        $this->refreshToken = $refreshToken;
    }
}
